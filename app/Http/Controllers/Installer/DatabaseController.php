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
 namespace App\Http\Controllers\Installer; use App\Http\Controllers\Installer\Helpers\DatabaseManager; use Exception; use Illuminate\Routing\Controller; use Illuminate\Support\Facades\DB; class DatabaseController extends Controller { private $databaseManager; public function __construct(DatabaseManager $databaseManager) { $this->databaseManager = $databaseManager; } public function database() { if ($this->checkDatabaseConnection()) { goto ywVFo; } return redirect()->back()->withErrors(["\x64\141\x74\141\142\x61\x73\145\137\143\x6f\x6e\x6e\x65\x63\x74\x69\157\156" => trans("\x69\x6e\163\x74\x61\x6c\154\x65\x72\x5f\155\x65\x73\x73\x61\x67\145\x73\x2e\x65\156\166\151\162\x6f\156\155\x65\156\164\56\167\151\172\141\162\144\56\x66\157\x72\x6d\x2e\144\x62\x5f\x63\157\156\156\x65\143\164\x69\x6f\156\x5f\146\141\151\x6c\x65\x64")]); ywVFo: ini_set("\x6d\141\170\137\x65\x78\145\143\165\x74\151\x6f\156\x5f\x74\151\x6d\145", 600); $response = $this->databaseManager->migrateAndSeed(); return redirect()->route("\111\x6e\163\164\x61\154\x6c\x65\x72\x2e\x66\x69\x6e\x61\154")->with(["\155\x65\x73\x73\141\147\x65" => $response]); } private function checkDatabaseConnection() { try { DB::connection()->getPdo(); return true; } catch (Exception $e) { return false; } } }
