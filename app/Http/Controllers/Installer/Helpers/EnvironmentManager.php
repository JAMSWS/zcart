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
 namespace App\Http\Controllers\Installer\Helpers; use Exception; use Illuminate\Http\Request; class EnvironmentManager { private $envPath; private $envExamplePath; public function __construct() { $this->envPath = base_path("\x2e\145\156\166"); $this->envExamplePath = base_path("\x2e\x65\x6e\x76\56\x65\170\x61\155\160\154\x65"); } public function getEnvContent() { if (file_exists($this->envPath)) { goto Rloef; } if (file_exists($this->envExamplePath)) { goto w1uYO; } touch($this->envPath); goto xB41j; w1uYO: copy($this->envExamplePath, $this->envPath); xB41j: Rloef: return file_get_contents($this->envPath); } public function getEnvPath() { return $this->envPath; } public function getEnvExamplePath() { return $this->envExamplePath; } public function saveFileClassic(Request $input) { $message = trans("\151\x6e\x73\164\141\154\x6c\x65\162\137\155\145\x73\163\141\147\x65\163\56\145\x6e\x76\x69\x72\157\156\x6d\x65\156\x74\56\163\x75\143\x63\x65\163\163"); try { file_put_contents($this->envPath, $input->get("\x65\156\x76\x43\x6f\x6e\x66\151\x67")); } catch (Exception $e) { $message = trans("\151\x6e\163\x74\141\x6c\x6c\x65\162\x5f\155\145\163\x73\x61\147\145\163\56\x65\156\166\151\162\x6f\x6e\x6d\145\156\164\x2e\145\x72\x72\157\x72\163"); } return $message; } }
