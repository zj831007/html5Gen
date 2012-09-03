<?php

$lang = array(

    '_locale' => "zh_CN.UTF-8",     // UNIX localization code
    '_charset' => "utf-8",       // Browser charset

    // Date time formats. See http://www.php.net/manual/en/function.strftime.php
    '_dateTimeFull' => "%A, %e %B, %Y %H:%M",
    '_dateTimeMid' => "%a %e %b %Y %H:%M",
    '_dateTimeSmall' => "%Y-%m-%d %H:%M",

   "You don't have permissions to upload files." =>
    "您沒有許可權上傳檔。",

    "You don't have permissions to browse server." =>
    "您沒有許可權查看伺服器檔。",

    "Cannot move uploaded file to target folder." =>
    "無法移動上傳檔到指定資料夾。",

    "Unknown error." =>
    "發生不可預知異常。",

    "The uploaded file exceeds {size} bytes." =>
    "檔大小超過{size}位元組。",

    "The uploaded file was only partially uploaded." =>
    "文件未完全上傳。",

    "No file was uploaded." =>
    "文件未上傳。",

    "Missing a temporary folder." =>
    "暫存檔案夾不存在。",

    "Failed to write file." =>
    "寫入檔失敗。",

    "Denied file extension." =>
    "禁止的檔副檔名。",

    "Unknown image format/encoding." =>
    "無法確認圖片格式。",

    "The image is too big and/or cannot be resized." =>
    "圖片大太，且（或）無法更改大小。",

    "Cannot create {dir} folder." =>
    "無法創建{dir}資料夾。",

    "Cannot write to upload folder." =>
    "無法寫入上傳資料夾。",

    "Cannot read .htaccess" =>
    "文件.htaccess無法讀取。",

    "Incorrect .htaccess file. Cannot rewrite it!" =>
    "文件.htaccess錯誤，無法重寫。",

    "Cannot read upload folder." =>
    "無法讀取上傳目錄。",

    "Cannot access or create thumbnails folder." =>
    "無法訪問或創建縮略圖資料夾。",

    "Cannot access or write to upload folder." =>
    "無法訪問或寫入上傳資料夾。",

    "Please enter new folder name." =>
    "請輸入資料夾名。",

    "Unallowable characters in folder name." =>
    "資料夾名含有禁止字元。",

    "Folder name shouldn't begins with '.'" =>
    "資料夾名不能以點（.）為首字元。",

    "Please enter new file name." =>
    "請輸入新檔案名。",

    "Unallowable characters in file name." =>
    "檔案名含有禁止字元。",

    "File name shouldn't begins with '.'" =>
    "檔案名不能以點（.）為首字元。",

    "Are you sure you want to delete this file?" =>
    "是否確認刪除該檔？",

    "Are you sure you want to delete this folder and all its content?" =>
    "是否確認刪除該資料夾以及其子檔和子目錄？",

    "Inexistant or inaccessible folder." =>
    "不存在或不可訪問的資料夾。",

    "Undefined MIME types." =>
    "未定義的MIME類型。",

    "Fileinfo PECL extension is missing." =>
    "檔PECL屬性不存在。",

    "Opening fileinfo database failed." =>
    "打開檔案屬性資料庫出錯。",

    "You can't upload such files." =>
    "你無法上傳該文件。",

    "The file '{file}' does not exist." =>
    "文件{file}不存在。",

    "Cannot read '{file}'." =>
    "無法讀取文件{file}。",

    "Cannot copy '{file}'." =>
    "無法複製檔{file}。",

    "Cannot move '{file}'." =>
    "無法移動文件{file}。",

    "Cannot delete '{file}'." =>
    "無法刪除檔{file}。",

    "Click to remove from the Clipboard" =>
    "點擊從剪貼板刪除",

    "This file is already added to the Clipboard." =>
    "檔已複製到剪貼板。",

    "Copy files here" =>
    "複製到這裡",

    "Move files here" =>
    "移動到這裡",

    "Delete files" =>
    "刪除這些檔",

    "Clear the Clipboard" =>
    "清除剪貼板",

    "Are you sure you want to delete all files in the Clipboard?" =>
    "是否確認刪除所有在剪貼板的檔？",

    "Copy {count} files" =>
    "複製 {count} 個檔",

    "Move {count} files" =>
    "移動 {count} 個文件 ",

    "Add to Clipboard" =>
    "添加到剪貼板",

    "New folder name:" => "新資料夾名：",
    "New file name:" => "新資料夾：",
	
	"You cannot rename the extension of files!" => "你不能修改檔副檔名",

    "Upload" => "上傳",
    "Refresh" => "刷新",
    "Settings" => "設置",
    "Maximize" => "最大化",
    "About" => "關於",
    "files" => "文件",
    "View:" => "視圖：",
    "Show:" => "顯示：",
    "Order by:" => "排序：",
    "Thumbnails" => "圖示",
    "List" => "列表",
    "Name" => "檔案名",
    "Size" => "大小",
    "Date" => "日期",
    "Descending" => "降冪",
    "Uploading file..." => "正在上傳文件...",
    "Loading image..." => "正在載入圖片...",
    "Loading folders..." => "正在載入資料夾...",
    "Loading files..." => "正在載入檔...",
    "New Subfolder..." => "新建資料夾...",
    "Rename..." => "重命名...",
    "Delete" => "刪除",
    "OK" => "OK",
    "Cancel" => "取消",
    "Select" => "選擇",
    "Select Thumbnail" => "選擇縮略圖",
    "View" => "查看",
    "Download" => "下載",
    "Clipboard" => "剪貼板",

    // VERSION 2 NEW LABELS

    "Cannot rename the folder." =>
    "無法重命名該資料夾。",

    "Non-existing directory type." =>
    "不存在的目錄類型。",

    "Cannot delete the folder." =>
    "無法刪除該資料夾。",

    "The files in the Clipboard are not readable." =>
    "剪貼板上該文件無法讀取。",

    "{count} files in the Clipboard are not readable. Do you want to copy the rest?" =>
    "剪貼板{count}個文件無法讀取。 是否複製靜態檔？",

    "The files in the Clipboard are not movable." =>
    "剪貼板上該文件無法移動。",

    "{count} files in the Clipboard are not movable. Do you want to move the rest?" =>
    "剪貼板{count}個文件無法移動。 是否移動靜態檔？",

    "The files in the Clipboard are not removable." =>
    "剪貼板上該檔無法刪除。",

    "{count} files in the Clipboard are not removable. Do you want to delete the rest?" =>
    "剪貼板{count}個檔無法刪除。 是否刪除靜態檔？",

    "The selected files are not removable." =>
    "選中檔未刪除。",

    "{count} selected files are not removable. Do you want to delete the rest?" =>
    "選中的{count}個檔未刪除。是否刪除靜態檔？",

    "Are you sure you want to delete all selected files?" =>
    "是否確認刪除選中檔？",

    "Failed to delete {count} files/folders." =>
    "{count}個檔或資料夾無法刪除。",

    "A file or folder with that name already exists." =>
    "文件或資料夾已存在。",

    "selected files" => "選中的文件",
    "Type" => "種類",
    "Select Thumbnails" => "選擇縮略圖",
    "Download files" => "下載檔案",

);

?>
