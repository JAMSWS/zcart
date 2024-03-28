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
 namespace App\Http\Controllers\Installer; use App\Http\Controllers\Installer\Helpers\RequirementsChecker; use Illuminate\Routing\Controller; class RequirementsController extends Controller { protected $requirements; public function __construct(RequirementsChecker $checker) { $this->requirements = $checker; } public function requirements() { $phpSupportInfo = $this->requirements->checkPHPversion(config("\151\x6e\x73\164\141\x6c\154\145\x72\56\143\x6f\x72\145\x2e\x6d\151\x6e\120\x68\160\126\x65\x72\163\x69\x6f\156"), config("\151\156\163\164\141\x6c\x6c\145\x72\x2e\x63\x6f\162\x65\x2e\155\x61\x78\x50\150\x70\126\145\162\x73\151\157\156")); $requirements = $this->requirements->check(config("\151\x6e\163\x74\141\x6c\x6c\x65\162\56\x72\x65\x71\x75\151\x72\x65\x6d\x65\x6e\x74\x73")); return view("\151\156\163\x74\x61\154\x6c\x65\x72\x2e\162\x65\x71\x75\151\x72\145\x6d\x65\156\x74\x73", compact("\x72\145\x71\x75\151\162\145\x6d\x65\156\x74\x73", "\160\150\x70\x53\x75\160\x70\157\x72\164\x49\x6e\x66\x6f")); } }
