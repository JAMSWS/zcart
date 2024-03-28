<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.14  |
    |              on 2023-10-02 21:21:44              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
/*
* Copyright (C) Incevio Systems, Inc - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
* Written by Munna Khan <help.zcart@gmail.com>, September 2018
*/
 namespace App\Http\Controllers\Installer\Helpers; class InstalledFileManager { public function create() { $installedLogFile = storage_path("\151\156\163\164\141\154\154\x65\144"); $dateStamp = date("\x59\57\155\57\144\x20\150\x3a\x69\72\163\141"); if (!file_exists($installedLogFile)) { goto RGc6k; } $message = trans("\151\x6e\x73\x74\141\x6c\x6c\x65\x72\137\155\145\x73\163\x61\x67\145\x73\x2e\165\x70\x64\x61\x74\145\x72\56\154\157\x67\x2e\x73\165\x63\143\x65\163\x73\x5f\155\x65\x73\163\x61\147\x65") . $dateStamp; file_put_contents($installedLogFile, $message . PHP_EOL, FILE_APPEND | LOCK_EX); goto CW1gU; RGc6k: $message = trans("\x69\x6e\x73\164\141\154\x6c\x65\x72\x5f\x6d\x65\163\163\141\147\x65\x73\x2e\x69\x6e\x73\x74\141\x6c\154\x65\x64\x2e\163\165\x63\x63\x65\163\x73\137\x6c\x6f\147\137\155\145\x73\163\x61\x67\145") . $dateStamp . "\xa"; file_put_contents($installedLogFile, $message); CW1gU: return $message; } public function update() { return $this->create(); } }
