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
 namespace App\Http\Controllers\Installer; use App\Http\Controllers\Installer\Helpers\DatabaseManager; use App\Http\Controllers\Installer\Helpers\InstalledFileManager; use Illuminate\Routing\Controller; class UpdateController extends Controller { use \App\Http\Controllers\Installer\Helpers\MigrationsHelper; public function welcome() { return view("\151\x6e\x73\x74\141\154\154\x65\x72\x2e\165\160\144\x61\x74\x65\56\x77\145\154\143\157\x6d\145"); } public function overview() { $migrations = $this->getMigrations(); $dbMigrations = $this->getExecutedMigrations(); return view("\x69\156\x73\164\141\x6c\x6c\145\x72\56\165\160\144\141\x74\x65\x2e\157\x76\x65\x72\x76\x69\x65\x77", ["\x6e\165\x6d\142\x65\x72\x4f\x66\125\160\144\x61\164\x65\163\x50\145\x6e\144\x69\156\147" => count($migrations) - count($dbMigrations)]); } public function database() { $databaseManager = new DatabaseManager(); $response = $databaseManager->migrateAndSeed(); return redirect()->route("\114\141\162\141\x76\145\154\x55\160\x64\141\x74\x65\162\x3a\x3a\146\x69\156\x61\154")->with(["\155\145\163\163\x61\147\145" => $response]); } public function finish(InstalledFileManager $fileManager) { $fileManager->update(); return view("\151\x6e\x73\164\141\154\x6c\x65\162\x2e\x75\x70\x64\141\x74\145\56\146\x69\x6e\151\163\150\x65\x64"); } }
