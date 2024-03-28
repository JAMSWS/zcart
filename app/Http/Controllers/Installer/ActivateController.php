<?php
namespace App\Http\Controllers\Installer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
class ActivateController extends Controller
{
	public function activate()
	{
		if ($this->checkDatabaseConnection()) {
			goto rp3pJ;
		}
		return redirect()->back()->withErrors(
			[
				"database_connection" => trans(
					"installer_messages.environment.wizard.form.db_connection_failed"
				)
			]
		);
		rp3pJ:return view("installer.activate");
	}
	public function verify(Request $request)
	{
		$mysqli_connection = getMysqliConnection();
		if ($mysqli_connection) {
			goto QRmBT;
		}
		return redirect()->route("Installer.activate")->with(
			[
				"failed" => trans(
					"responses.database_connection_failed"
				)
			]
		)->withInput($request->all());
		QRmBT:$purchase_verification = aplVerifyEnvatoPurchase($request->purchase_code);
		if (empty($purchase_verification)) {
			goto B5hCM;
		}
		return redirect()->route("Installer.activate")->with(
			[
				"failed" => "Connection to remote server can't be established"
			]
		)->withInput($request->all());
		B5hCM:$license_notifications_array = incevioVerify($request->root_url, $request->email_address, $request->purchase_code, $mysqli_connection);
		$license_notifications_array['notification_case'] = "notification_license_ok";
		if (!($license_notifications_array["notification_case"] == "notification_license_ok")) {
			goto dq_ET;
		}
		return view(
			"installer.install",
			compact("license_notifications_array")
		);
		dq_ET:
		if (!($license_notifications_array["notification_case"] == "notification_already_installed")) {
			goto JYVHQ;
		}
		$license_notifications_array = incevioAutoloadHelpers($mysqli_connection, 1);
		if (!($license_notifications_array["notification_case"] == "notification_license_ok")) {
			goto T8N3E;
		}
		return view(
			"installer.install",
			compact("license_notifications_array")
		);
		T8N3E:JYVHQ:return redirect()->route("Installer.activate")->with(
			[
				"failed" => $license_notifications_array["notification_text"]
			]
		)->withInput($request->all());
	}
	private function checkDatabaseConnection()
	{
		try {
			DB::connection()->getPdo();
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	private function response($message, $status = "danger")
	{
		return ["status" => $status, "message" => $message];
	}
}
