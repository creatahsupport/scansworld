<?php
error_reporting(0);
ob_start();
session_start();
if(($_SESSION['empid'] == '') && ($_SESSION['fname'] == '') && ($_SESSION['lastloginon'] == '') && ($_SESSION['location'] == '') && ($_SESSION['role'] == ''))
{ 
    header("Location: index.php");
    exit;
}

// Configuration
$base_dir = realpath(dirname(__DIR__)); // Go one level up from admin folder
$allowed_extensions = ['php', 'html', 'htm', 'css', 'js', 'txt', 'json', 'xml', 'sql', 'env', 'htaccess'];
$backup_dir = $base_dir . '/backups/';

// Create backups directory if it doesn't exist
if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0755, true);
}

// Get current directory path from request
$current_dir = $_GET['dir'] ?? '';
$requested_file = $_GET['file'] ?? 'index.php';

// Build full path for file
if ($requested_file) {
    // Handle relative paths with ../
    if (strpos($requested_file, '..') !== false) {
        $file_path = realpath($base_dir . '/' . $requested_file);
    } else {
        $file_path = $base_dir . '/' . ltrim($requested_file, '/');
    }
} else {
    $file_path = '';
}

// Build directory path for browsing
if ($current_dir) {
    $dir_path = $base_dir . '/' . ltrim($current_dir, '/');
    if (!is_dir($dir_path)) {
        $dir_path = $base_dir;
        $current_dir = '';
    }
} else {
    $dir_path = $base_dir;
}

// Security: prevent directory traversal outside base directory
$file_path = realpath($file_path);
if ($file_path && strpos($file_path, $base_dir) !== 0) {
    $file_path = '';
    $requested_file = '';
}

$dir_path = realpath($dir_path);
if ($dir_path && strpos($dir_path, $base_dir) !== 0) {
    $dir_path = $base_dir;
    $current_dir = '';
}

// Get file name for display
if ($requested_file && $file_path) {
    $current_file = basename($requested_file);
} else {
    $current_file = '';
}

// Check if file exists
$file_exists = ($file_path && file_exists($file_path));

// Get file extension for syntax highlighting
$file_ext = $file_exists ? pathinfo($file_path, PATHINFO_EXTENSION) : '';

// Messages array
$messages = [];

// Handle file operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if we're opening a new file
    if (isset($_POST['open_file']) && !empty($_POST['file_to_open'])) {
        $new_file = $_POST['file_to_open'];
        // Clean the path
        $new_file = ltrim($new_file, '/');
        header('Location: ?file=' . urlencode($new_file) . ($current_dir ? '&dir=' . urlencode($current_dir) : ''));
        exit;
    }
    
    // Save file content
    if (isset($_POST['save']) && isset($_POST['content']) && $file_exists) {
        // Create backup before saving
        $backup_name = str_replace('/', '_', $requested_file) . '_backup_' . date('Y-m-d_H-i-s') . '.' . $file_ext;
        copy($file_path, $backup_dir . $backup_name);
        
        // Save the file
        if (file_put_contents($file_path, $_POST['content'])) {
            $messages[] = ['type' => 'success', 'text' => 'File saved successfully! Backup created.'];
        } else {
            $messages[] = ['type' => 'error', 'text' => 'Error saving file.'];
        }
    }
    
    // Create new file
    if (isset($_POST['create_file']) && !empty($_POST['new_filename'])) {
        $new_file = basename($_POST['new_filename']);
        $new_path = $dir_path . '/' . $new_file;
        
        if (!file_exists($new_path)) {
            file_put_contents($new_path, '');
            header('Location: ?file=' . urlencode(($current_dir ? $current_dir . '/' : '') . $new_file) . ($current_dir ? '&dir=' . urlencode($current_dir) : ''));
            exit;
        } else {
            $messages[] = ['type' => 'error', 'text' => 'File already exists.'];
        }
    }
    
    // Restore from backup
    if (isset($_POST['restore']) && $file_exists) {
        $backup_file = $_POST['backup_file'] ?? '';
        if ($backup_file && file_exists($backup_dir . $backup_file)) {
            $backup_content = file_get_contents($backup_dir . $backup_file);
            if (file_put_contents($file_path, $backup_content)) {
                $messages[] = ['type' => 'success', 'text' => 'File restored from backup: ' . $backup_file];
            }
        }
    }
    
    // Create new backup
    if (isset($_POST['create_backup']) && $file_exists) {
        $backup_name = str_replace('/', '_', $requested_file) . '_manual_backup_' . date('Y-m-d_H-i-s') . '.' . $file_ext;
        if (copy($file_path, $backup_dir . $backup_name)) {
            $messages[] = ['type' => 'success', 'text' => 'Manual backup created: ' . $backup_name];
        }
    }
    
    // Download file
    if (isset($_POST['download']) && $file_exists) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        readfile($file_path);
        exit;
    }
}

// Get current file content
$file_content = '';
$file_info = [];
$backup_files = [];
$directory_files = [];
$subdirectories = [];

if ($file_exists) {
    // Read file content
    $file_content = file_get_contents($file_path);
    
    $file_info = [
        'size' => filesize($file_path),
        'modified' => date('Y-m-d H:i:s', filemtime($file_path)),
        'created' => date('Y-m-d H:i:s', filectime($file_path)),
        'permissions' => substr(sprintf('%o', fileperms($file_path)), -4),
        'readable' => is_readable($file_path),
        'writable' => is_writable($file_path)
    ];
}

// Get list of backup files for current file
if (is_dir($backup_dir) && $file_exists) {
    $backup_pattern = str_replace('/', '_', $requested_file) . '_backup_*';
    if ($file_ext) {
        $backup_pattern .= '.' . $file_ext;
    }
    $backup_files = array_reverse(glob($backup_dir . $backup_pattern));
    $backup_files = array_map('basename', $backup_files);
}

// Get list of files and directories in current directory
if (is_dir($dir_path)) {
    $all_items = scandir($dir_path);
    
    foreach ($all_items as $item) {
        if ($item == '.' || $item == '..' || $item == 'admin' || $item == 'backups') {
            continue;
        }
        
        $full_path = $dir_path . '/' . $item;
        
        if (is_dir($full_path)) {
            $subdirectories[] = $item;
        } else {
            // Check extension
            $ext = pathinfo($item, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $allowed_extensions)) {
                $directory_files[] = $item;
            }
        }
    }
    
    sort($subdirectories);
    sort($directory_files);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Editor - <?php echo htmlspecialchars($current_file ?: 'Browse'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/dracula.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/clike/clike.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/edit/matchbrackets.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/edit/closebrackets.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/foldcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/foldgutter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/brace-fold.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 20px;
        }
        
        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar h3 {
            color: #374151;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .breadcrumb {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 15px;
            padding: 8px 12px;
            background: #f3f4f6;
            border-radius: 4px;
        }
        
        .breadcrumb a {
            color: #007acc;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .dir-list, .file-list {
            list-style: none;
            margin-bottom: 20px;
        }
        
        .dir-list {
            max-height: 200px;
            overflow-y: auto;
        }
        
        .file-list {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .dir-list li, .file-list li {
            margin-bottom: 5px;
        }
        
        .dir-list a, .file-list a {
            display: block;
            padding: 8px 12px;
            background: #f3f4f6;
            border-radius: 4px;
            color: #4b5563;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
            word-break: break-all;
        }
        
        .dir-list a:hover, .file-list a:hover {
            background: #e5e7eb;
            color: #374151;
        }
        
        .file-list a.active {
            background: #007acc;
            color: white;
            font-weight: 500;
        }
        
        .create-file-form {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        
        .create-file-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 13px;
        }
        
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header h1 {
            color: #374151;
            margin-bottom: 10px;
            font-size: 24px;
        }
        
        .header p {
            color: #6b7280;
            font-size: 14px;
        }
        
        .file-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            margin-top: 15px;
            padding: 15px;
            background: #f3f4f6;
            border-radius: 6px;
        }
        
        .info-item {
            font-size: 12px;
        }
        
        .info-label {
            font-weight: 600;
            color: #4b5563;
            display: block;
        }
        
        .info-value {
            color: #1f2937;
            font-family: 'Monaco', 'Menlo', monospace;
        }
        
        .permission-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .permission-readable {
            background: #d1fae5;
            color: #065f46;
        }
        
        .permission-writable {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .editor-container {
            background: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            flex: 1;
        }
        
        .editor-toolbar {
            background: #252526;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #3e3e42;
        }
        
        .file-path {
            color: #d4d4d4;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 12px;
            padding: 6px 10px;
            background: #2d2d30;
            border-radius: 4px;
            max-width: 400px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .button-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-primary {
            background: #007acc;
            color: white;
        }
        
        .btn-primary:hover {
            background: #005a9e;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #545b62;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-warning:hover {
            background: #e0a800;
        }
        
        .CodeMirror {
            height: 500px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .backup-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .backup-section h3 {
            color: #374151;
            margin-bottom: 15px;
        }
        
        .backup-list {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 15px;
        }
        
        .backup-item {
            padding: 10px 15px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .backup-item:last-child {
            border-bottom: none;
        }
        
        .backup-name {
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 12px;
            color: #4b5563;
        }
        
        .backup-actions {
            display: flex;
            gap: 8px;
        }
        
        .btn-sm {
            padding: 4px 8px;
            font-size: 11px;
        }
        
        .messages {
            margin-bottom: 20px;
        }
        
        .alert {
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }
        
        .close-btn {
            background: none;
            border: none;
            color: inherit;
            font-size: 20px;
            cursor: pointer;
            opacity: 0.7;
        }
        
        .close-btn:hover {
            opacity: 1;
        }
        
        .restore-form {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 15px;
            padding: 15px;
            background: #f3f4f6;
            border-radius: 6px;
        }
        
        select {
            flex: 1;
            padding: 8px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            background: white;
        }
        
        .no-file {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }
        
        .open-file-form {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .open-file-form input {
            flex: 1;
            padding: 8px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 13px;
        }
        
        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                order: 2;
            }
            
            .main-content {
                order: 1;
            }
        }
        
        @media (max-width: 768px) {
            .editor-toolbar {
                flex-direction: column;
                gap: 10px;
                align-items: stretch;
            }
            
            .button-group {
                flex-wrap: wrap;
            }
            
            .btn {
                flex: 1;
                justify-content: center;
            }
            
            .file-info {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar with file list -->
        <div class="sidebar">
            <h3>📁 File Browser</h3>
            
            <div class="breadcrumb">
                <a href="?">Root</a>
                <?php if ($current_dir): ?>
                    <?php 
                    $parts = explode('/', $current_dir);
                    $current_path = '';
                    foreach ($parts as $part):
                        $current_path .= ($current_path ? '/' : '') . $part;
                    ?>
                        &raquo; <a href="?dir=<?php echo urlencode($current_path); ?>"><?php echo htmlspecialchars($part); ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($subdirectories)): ?>
                <h4>📂 Directories</h4>
                <ul class="dir-list">
                    <?php foreach ($subdirectories as $dir): ?>
                        <li>
                            <a href="?dir=<?php echo urlencode(($current_dir ? $current_dir . '/' : '') . $dir); ?>">
                                📁 <?php echo htmlspecialchars($dir); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
            <?php if (!empty($directory_files)): ?>
                <h4>📄 Files</h4>
                <ul class="file-list">
                    <?php foreach ($directory_files as $file): ?>
                        <?php 
                        $relative_path = ($current_dir ? $current_dir . '/' : '') . $file;
                        $is_active = ($requested_file == $relative_path);
                        ?>
                        <li>
                            <a href="?file=<?php echo urlencode($relative_path); ?>&dir=<?php echo urlencode($current_dir); ?>" 
                               class="<?php echo $is_active ? 'active' : ''; ?>">
                                <?php 
                                $icon = '📄';
                                $ext = pathinfo($file, PATHINFO_EXTENSION);
                                if ($ext === 'php') $icon = '🐘';
                                elseif ($ext === 'html' || $ext === 'htm') $icon = '🌐';
                                elseif ($ext === 'css') $icon = '🎨';
                                elseif ($ext === 'js') $icon = '📜';
                                elseif ($ext === 'sql') $icon = '🗄️';
                                echo $icon . ' ' . htmlspecialchars($file); 
                                ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
            <div class="create-file-form">
                <h3>➕ New File</h3>
                <form method="POST" action="">
                    <input type="text" name="new_filename" placeholder="example.php" required>
                    <button type="submit" name="create_file" class="btn btn-success" style="width: 100%;">
                        Create File in Current Directory
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="main-content">
            <!-- Messages -->
            <div class="messages">
                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-<?php echo $message['type']; ?>">
                        <?php echo $message['text']; ?>
                        <button class="close-btn" onclick="this.parentElement.style.display='none'">×</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Header -->
            <div class="header" style="margin-top: -48px;">
                <h1>
                    <?php if ($file_exists): ?>
                        📝 File Editor - <?php echo htmlspecialchars($current_file); ?>
                    <?php else: ?>
                        📁 File Browser - <?php echo htmlspecialchars($current_dir ?: 'Root'); ?>
                    <?php endif; ?>
                </h1>
                <p>
                    <?php if ($file_exists): ?>
                        Editing file: <?php echo htmlspecialchars($requested_file); ?>
                    <?php else: ?>
                        Browse and edit files in your project directory
                    <?php endif; ?>
                </p>
                
                <div class="open-file-form">
                    <form method="POST" action="" style="display: flex; gap: 10px; width: 100%;">
                        <input type="text" name="file_to_open" 
                               placeholder="Enter filename or path (e.g., aboutus.php, include/config.php, ../footer.php)" 
                               value="<?php echo htmlspecialchars($requested_file); ?>" 
                               required>
                        <button type="submit" name="open_file" class="btn btn-primary">Open File</button>
                    </form>
                </div>
                
                <?php if ($file_exists): ?>
                    <div class="file-info">
                        <div class="info-item">
                            <span class="info-label">Path:</span>
                            <span class="info-value"><?php echo htmlspecialchars($file_path); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Size:</span>
                            <span class="info-value"><?php echo number_format($file_info['size']); ?> bytes</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Modified:</span>
                            <span class="info-value"><?php echo $file_info['modified']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Created:</span>
                            <span class="info-value"><?php echo $file_info['created']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Permissions:</span>
                            <span class="info-value"><?php echo $file_info['permissions']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status:</span>
                            <span class="info-value">
                                <?php if ($file_info['readable']): ?>
                                    <span class="permission-badge permission-readable">Readable</span>
                                <?php endif; ?>
                                <?php if ($file_info['writable']): ?>
                                    <span class="permission-badge permission-writable">Writable</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                <?php elseif ($requested_file && !$file_exists): ?>
                    <div class="no-file">
                        <p>File <strong><?php echo htmlspecialchars($requested_file); ?></strong> does not exist.</p>
                        <p>You can create it by entering the filename above or select an existing file from the sidebar.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if ($file_exists): ?>
                <!-- Editor -->
                <form method="POST" action="" id="editorForm">
                    <div class="editor-container">
                        <div class="editor-toolbar">
                            <div class="file-path" title="<?php echo htmlspecialchars($file_path); ?>">
                                <?php echo htmlspecialchars($file_path); ?>
                            </div>
                            <div class="button-group">
                                <button type="submit" name="save" class="btn btn-primary">
                                    💾 Save (Ctrl+S)
                                </button>
                                <button type="submit" name="download" class="btn btn-secondary">
                                    ⬇️ Download
                                </button>
                                <button type="submit" name="create_backup" class="btn btn-success">
                                    📦 Create Backup
                                </button>
                                <a href="?file=<?php echo urlencode($requested_file); ?>&dir=<?php echo urlencode($current_dir); ?>" class="btn btn-warning">
                                    🔄 Reload
                                </a>
                            </div>
                        </div>
                        
                        <!-- Hidden textarea for form submission -->
                        <textarea name="content" id="fileContent" style="display: none;"><?php 
                            echo htmlspecialchars($file_content, ENT_NOQUOTES);
                        ?></textarea>
                        
                        <!-- CodeMirror editor -->
                        <div id="codeEditor"></div>
                    </div>
                </form>
                
                <!-- Backup Management -->
                <?php if (!empty($backup_files)): ?>
                    <div class="backup-section">
                        <h3>📦 Available Backups</h3>
                        <div class="backup-list">
                            <?php foreach ($backup_files as $backup): ?>
                                <div class="backup-item">
                                    <span class="backup-name"><?php echo htmlspecialchars($backup); ?></span>
                                    <div class="backup-actions">
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="viewBackup('<?php echo $backup; ?>')">
                                            👁️ View
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <form method="POST" action="" class="restore-form">
                            <select name="backup_file" required>
                                <option value="">Select a backup to restore</option>
                                <?php foreach ($backup_files as $backup): ?>
                                    <option value="<?php echo htmlspecialchars($backup); ?>"><?php echo htmlspecialchars($backup); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" name="restore" class="btn btn-warning">
                                🔄 Restore from Backup
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        // Initialize CodeMirror editor
        <?php if ($file_exists): ?>
        const textarea = document.getElementById('fileContent');
        const editor = CodeMirror(document.getElementById('codeEditor'), {
            value: textarea.value,
            lineNumbers: true,
            mode: getMode('<?php echo $file_ext; ?>'),
            theme: 'dracula',
            matchBrackets: true,
            autoCloseBrackets: true,
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
            lineWrapping: true,
            indentUnit: 4,
            tabSize: 4,
            indentWithTabs: false,
            extraKeys: {
                "Ctrl-S": function(instance) { document.getElementById('editorForm').submit(); },
                "Cmd-S": function(instance) { document.getElementById('editorForm').submit(); }
            }
        });
        
        // Update hidden textarea when editor content changes
        editor.on('change', function() {
            textarea.value = editor.getValue();
        });
        <?php endif; ?>
        
        // Determine CodeMirror mode based on file extension
        function getMode(extension) {
            switch(extension) {
                case 'php': return {name: 'php', startOpen: true};
                case 'html': 
                case 'htm': return 'htmlmixed';
                case 'css': return 'css';
                case 'js': return 'javascript';
                case 'json': return {name: 'javascript', json: true};
                case 'xml': return 'xml';
                case 'sql': return {name: 'text/x-sql'};
                default: return 'application/x-httpd-php';
            }
        }
        
        // Backup viewer function
        function viewBackup(filename) {
            const modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0,0,0,0.8)';
            modal.style.zIndex = '10000';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
            
            const content = document.createElement('div');
            content.style.background = '#1e1e1e';
            content.style.padding = '20px';
            content.style.borderRadius = '10px';
            content.style.width = '90%';
            content.style.height = '90%';
            content.style.overflow = 'hidden';
            content.style.display = 'flex';
            content.style.flexDirection = 'column';
            
            const header = document.createElement('div');
            header.style.display = 'flex';
            header.style.justifyContent = 'space-between';
            header.style.alignItems = 'center';
            header.style.marginBottom = '15px';
            header.style.color = 'white';
            
            const title = document.createElement('h3');
            title.textContent = 'Viewing Backup: ' + filename;
            title.style.color = 'white';
            
            const closeBtn = document.createElement('button');
            closeBtn.textContent = '✕';
            closeBtn.style.background = '#dc3545';
            closeBtn.style.color = 'white';
            closeBtn.style.border = 'none';
            closeBtn.style.borderRadius = '4px';
            closeBtn.style.padding = '8px 16px';
            closeBtn.style.cursor = 'pointer';
            closeBtn.onclick = function() {
                document.body.removeChild(modal);
            };
            
            header.appendChild(title);
            header.appendChild(closeBtn);
            
            const iframe = document.createElement('iframe');
            iframe.style.flex = '1';
            iframe.style.border = 'none';
            iframe.style.background = 'white';
            iframe.src = 'view_backup.php?file=' + encodeURIComponent(filename);
            
            content.appendChild(header);
            content.appendChild(iframe);
            modal.appendChild(content);
            document.body.appendChild(modal);
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+S or Cmd+S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.querySelector('button[name="save"]')?.click();
            }
            
            // Ctrl+O or Cmd+O to open file dialog
            if ((e.ctrlKey || e.metaKey) && e.key === 'o') {
                e.preventDefault();
                document.querySelector('input[name="file_to_open"]')?.focus();
            }
        });
        
        // Auto-focus file input
        document.querySelector('input[name="file_to_open"]')?.focus();
    </script>
</body>
</html>