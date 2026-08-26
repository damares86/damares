<?php
declare(strict_types=1);

class File extends Common
{
    public $table = 'files';
    public $filename;
    public $filename_orig;
    public $label;
    public $inputFileName;
    public $path = '../uploads';
    public $origin;

    public function uploadFile(): bool
    {
        if (!is_string($this->filename) || $this->filename === '' || !is_string($this->inputFileName)) {
            return false;
        }

        $this->filename = basename($this->filename);
        $extension = strtolower((string) pathinfo($this->filename, PATHINFO_EXTENSION));
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'pdf', 'doc', 'docx', 'zip', 'mp3'];
        if (!in_array($extension, $allowedExtensions, true) || !is_file($this->inputFileName)) {
            return false;
        }

        $targetDirectory = rtrim((string) $this->path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $targetFile = $targetDirectory . $this->filename;
        if (!is_dir($targetDirectory) && !mkdir($targetDirectory, 0755, true) && !is_dir($targetDirectory)) {
            return false;
        }

        if (is_file($targetFile) && !rename($targetFile, $targetFile . '_old')) {
            return false;
        }

        if (!move_uploaded_file($this->inputFileName, $targetFile)) {
            return false;
        }

        $query = match ($this->operation) {
            'add' => sprintf(
                'INSERT INTO %s (filename, label) VALUES (:filename, :label)',
                $this->tableName()
            ),
            'edit' => sprintf(
                'UPDATE %s SET filename = :filename, label = :label WHERE id = :id',
                $this->tableName()
            ),
            default => null,
        };

        if ($query === null) {
            return false;
        }

        $parameters = [':filename' => $this->filename, ':label' => $this->label];
        if ($this->operation === 'edit') {
            $parameters[':id'] = $this->id;
        }
        $this->executeQuery($query, $parameters);

        return true;
    }

    public function countFile(): int
    {
        return $this->countItem('filename');
    }

    public function showIdByFilename(): int|false
    {
        $query = sprintf('SELECT id FROM %s WHERE filename = :filename LIMIT 1', $this->tableName());
        $row = $this->executeQuery($query, [':filename' => $this->filename_orig])->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return false;
        }

        return $this->id = (int) $row['id'];
    }

    public function showFilenameById(): string|false
    {
        $query = sprintf('SELECT filename FROM %s WHERE id = :id LIMIT 1', $this->tableName());
        $row = $this->executeQuery($query, [':id' => $this->id])->fetch(PDO::FETCH_ASSOC);

        return $row === false ? false : (string) $row['filename'];
    }
}
