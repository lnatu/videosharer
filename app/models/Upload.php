<?php

class Upload {

    private $db;
    private $ffmpegPath;
    private $ffprobePath;
    private $sizeLimit = 500000000;
    private $allowedType = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg");

    public function __construct() {
        $this -> db = new Database();
        $this -> ffmpegPath = realpath("../app/lib/ffmpeg/bin/ffmpeg.exe");
        $this -> ffprobePath = realpath("../app/lib/ffmpeg/bin/ffprobe.exe");
    }

    public function uploadVideo($upload) {
        $targetDir = "assets/uploads/videos/";
        $videoData = $upload['file'];
        $tempPath = $targetDir.uniqid().basename($videoData['name']);
        $tempPath = str_replace(" ", "_", $tempPath);
        $isValid = $this -> process($videoData, $tempPath);

        if (!$isValid) {
            return false;
        }

        if (move_uploaded_file($videoData["tmp_name"], $tempPath)) {
            $finalPath = $targetDir.uniqid().".mp4";
            if (!$this -> insertVideoData($upload, $finalPath)) {
                echo "Insert query failed <br>";
                return false;
            }

            if (!$this -> converMp4($tempPath, $finalPath)) {
                echo "Upload failed <br>";
                return false;
            }
            
            if (!$this -> deleteFile($tempPath)) {
                echo "Upload failed <br>";
                return false;
            }

            if (!$this -> generateThumbnails($finalPath)) {
                echo "Upload failed - could not generate thumbnail <br>";
                return false;
            }

            return true;
        }
    }

    private function process($videoData, $filePath) {
        $videoType = pathinfo($filePath, PATHINFO_EXTENSION);
        if (!$this -> isValidSize($videoData)) {
            echo "File too large";
            return false;
        } else if (!$this -> isValidType($videoType)) {
            echo "Invalid type";
            return false;
        } else if ($this -> hasError($videoData)) {
            echo "Error code: ".$videoData["error"];
            return false;
        }
        return true;
    }

    private function insertVideoData($uploadData, $filePath) {
        $this -> db -> query("INSERT INTO video(title, uploadedBy, description, status, category, file_path) VALUES(:title, :uploadedBy, :description, :status, :category, :file_path)");

        $this -> db -> bind(":title", $uploadData['title']);
        $this -> db -> bind(":uploadedBy", $uploadData['uploadedBy']);
        $this -> db -> bind(":description", $uploadData['description']);
        $this -> db -> bind(":status", $uploadData['status']);
        $this -> db -> bind(":category", $uploadData['category']);
        $this -> db -> bind(":file_path", $filePath);
        
        return $this -> db -> execute();

    }

    private function isValidSize($data) {
        return $data["size"] <= $this -> sizeLimit;
    }

    private function isValidType($type) {
        $lowercase = strtolower($type);
        return in_array($lowercase, $this -> allowedType);
    }

    private function hasError($data) {
        return $data["error"] != 0;
    }

    public function converMp4($tempPath, $finalPath) {
        $cmd = "$this->ffmpegPath -i $tempPath $finalPath 2>&1";
        $outputLog = array();
        exec($cmd, $outputLog, $returnCode);
        
        if ($returnCode != 0) {
            foreach($outputLog as $line) {
                echo $line."<br>";
            }
            return false;
        }

        return true;
    }

    private function deleteFile($filePath) {
        if (!unlink($filePath)) {
            echo "Could not delete file";
            return false;
        }
        return true;
    }

    public function generateThumbnails($filePath) {
        $thumbnailSize = "210x118";
        $totalThumbnails = 3;
        $pathThumbnail = "assets/uploads/videos/thumbnails";

        $duration = $this -> getVideoDuration($filePath);
        $videoId = $this -> db -> lastInsertId();
        $this -> updateDuration($duration, $videoId);
        for ($i = 1; $i < $totalThumbnails; $i++) {
            $imageName = uniqid().".jpg";
            $interval = ($duration * 0.8) / $totalThumbnails * $i;
            $fullThumbnailPath = "$pathThumbnail/$videoId-$imageName";
            
            $cmd = "$this->ffmpegPath -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";
            $outputLog = array();
            exec($cmd, $outputLog, $returnCode);
            
            if ($returnCode != 0) {
                foreach($outputLog as $line) {
                    echo $line."<br>";
                }
            }
            $selected = $i == 1 ? 1 : 0;
            $this -> db -> query("INSERT INTO thumbnails(video_id, file_path, selected) VALUES(:video_id, :file_path, :selected)");
            $this -> db -> bind("video_id", $videoId);
            $this -> db -> bind("file_path", $fullThumbnailPath);
            $this -> db -> bind("selected", $selected);
            if (!$this -> db -> execute()) {
                echo "Error inserting thumbnail";
                return false;
            }
        }
        return true;
    }

    private function getVideoDuration($filePath) {
        return (int)shell_exec("$this->ffprobePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    }

    private function updateDuration($duration, $videoId) {
        $hours = floor($duration / 3600);
        $mins = floor(($duration - ($hours * 3600)) / 60);
        $secs = floor($duration % 60);

        $hours = ($hours < 1) ? "" : $hours.":";
        $mins = ($mins < 10) ? "0".$mins.":" : $mins.":";
        $secs = ($secs < 10) ? "0".$secs : $secs;

        $duration = $hours.$mins.$secs;

        $this -> db -> query("UPDATE video SET duration=:duration WHERE id=:videoId");
        $this -> db -> bind(":duration", $duration);
        $this -> db -> bind(":videoId", $videoId);
        return $this -> db -> execute();
    }
}