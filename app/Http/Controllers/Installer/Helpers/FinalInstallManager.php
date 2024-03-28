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
 namespace App\Http\Controllers\Installer\Helpers; use Exception; use Illuminate\Support\Facades\Artisan; use Symfony\Component\Console\Output\BufferedOutput; class FinalInstallManager { public function runFinal() { $outputLog = new BufferedOutput(); $this->generateKey($outputLog); $this->publishVendorAssets($outputLog); return $outputLog->fetch(); } private static function generateKey($outputLog) { try { if (!config("\151\x6e\163\x74\x61\x6c\x6c\x65\x72\56\x66\x69\156\x61\x6c\x2e\153\x65\171")) { goto JHyHk; } Artisan::call("\x6b\x65\171\x3a\147\x65\x6e\x65\162\x61\x74\145", ["\x2d\55\146\157\x72\143\145" => true], $outputLog); JHyHk: } catch (Exception $e) { return static::response($e->getMessage(), $outputLog); } return $outputLog; } private static function publishVendorAssets($outputLog) { try { if (!config("\151\156\163\x74\x61\x6c\x6c\145\162\56\x66\151\156\x61\154\56\x70\165\142\154\x69\x73\150")) { goto ipQqS; } Artisan::call("\x76\x65\x6e\x64\157\162\x3a\160\x75\142\154\151\x73\150", ["\x2d\x2d\x61\154\x6c" => true], $outputLog); ipQqS: } catch (Exception $e) { return static::response($e->getMessage(), $outputLog); } return $outputLog; } private static function response($message, $outputLog) { return ["\x73\164\x61\164\x75\163" => "\x65\x72\x72\x6f\162", "\x6d\x65\x73\x73\x61\x67\145" => $message, "\144\x62\x4f\165\164\160\165\164\114\x6f\147" => $outputLog->fetch()]; } }
