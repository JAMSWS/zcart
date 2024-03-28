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
 namespace App\Http\Controllers\Installer\Helpers; class PermissionsChecker { protected $results = []; public function __construct() { $this->results["\160\145\162\155\151\163\x73\151\157\x6e\163"] = []; $this->results["\145\x72\162\x6f\x72\x73"] = null; } public function check(array $folders) { foreach ($folders as $folder => $permission) { if (!($this->getPermission($folder) >= $permission)) { goto jFa6i; } $this->addFile($folder, $permission, true); goto lc3Ae; jFa6i: $this->addFileAndSetErrors($folder, $permission, false); lc3Ae: j1pO8: } cY42k: return $this->results; } private function getPermission($folder) { return substr(sprintf("\45\157", fileperms(base_path($folder))), -4); } private function addFile($folder, $permission, $isSet) { array_push($this->results["\160\x65\162\155\151\163\163\x69\x6f\x6e\x73"], ["\146\x6f\x6c\144\x65\x72" => $folder, "\x70\x65\x72\x6d\x69\163\x73\x69\157\156" => $permission, "\x69\163\x53\145\164" => $isSet]); } private function addFileAndSetErrors($folder, $permission, $isSet) { $this->addFile($folder, $permission, $isSet); $this->results["\145\162\162\157\162\163"] = true; } }
