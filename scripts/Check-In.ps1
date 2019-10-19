###
# David Bray
# BrayWorth Pty Ltd
# e. david@brayworth.com.au
#
# This work is licensed under a Creative Commons Attribution 4.0 International Public License.
# http://creativecommons.org/licenses/by/4.0/
#
# Credit:
#	https://gallery.technet.microsoft.com/scriptcenter/PowerShell-to-Check-if-811b83bc
#
# Other Articles
#	https://www.techrepublic.com/article/using-powershell-to-investigate-windows-defenders-malware-signature-definitions-database/
# 	https://docs.microsoft.com/en-us/windows/security/threat-protection/microsoft-defender-atp/enable-controlled-folders#powershell
#
#
# Execution Policies
# 	https://docs.microsoft.com/en-us/powershell/module/microsoft.powershell.security/set-executionpolicy?view=powershell-6
#
# Signing Scripts
#	https://www.hanselman.com/blog/SigningPowerShellScripts.aspx
#
# To sign a script with your codecert - if it is installed and valid
#	Set-AuthenticodeSignature c:\foo.ps1 @(Get-ChildItem cert:\CurrentUser\My -codesign)[0]
#
###

$url = "http://localhost"	# development environment
$params = @{
	key                          = "-- some random password --";
	locale                       = $env:computername; # 45 chr max
	action                       = "wemp-log"; # 45 chr max

	defender                     = 'Disabled';
	defenderService              = 'Disabled';
	Antispyware                  = 'Disabled';
	OnAccessProtection           = 'Disabled';
	RealTimeProtection           = 'Disabled';
	executionPolicy_UserPolicy   = Get-ExecutionPolicy UserPolicy;
	executionPolicy_Process      = Get-ExecutionPolicy Process;
	executionPolicy_CurrentUser  = Get-ExecutionPolicy CurrentUser;
	executionPolicy_LocalMachine = Get-ExecutionPolicy LocalMachine;

}

Try
{
	$defenderOptions = Get-MpComputerStatus;

    if([string]::IsNullOrEmpty($defenderOptions)) {}
    else {
		# AMEngineVersion                 : 1.1.16400.2
		# AMProductVersion                : 4.18.1909.6
		# AMServiceVersion                : 4.18.1909.6
		# AntispywareSignatureAge         : 0
		# AntispywareSignatureLastUpdated : 15/10/2019 1:28:42 AM
		# AntispywareSignatureVersion     : 1.303.1684.0
		# AntivirusSignatureAge           : 0
		# AntivirusSignatureLastUpdated   : 15/10/2019 1:28:43 AM
		# AntivirusSignatureVersion       : 1.303.1684.0
		# BehaviorMonitorEnabled          : True
		# ComputerID                      : 461FADE4-45EC-4933-A9DE-AB707E4F03D5
		# ComputerState                   : 0
		# FullScanAge                     : 4294967295
		# FullScanEndTime                 :
		# FullScanStartTime               :
		# IoavProtectionEnabled           : True
		# IsTamperProtected               : True
		# IsVirtualMachine                : False
		# LastFullScanSource              : 0
		# LastQuickScanSource             : 2
		# NISEnabled                      : True
		# NISEngineVersion                : 1.1.16400.2
		# NISSignatureAge                 : 0
		# NISSignatureLastUpdated         : 15/10/2019 1:28:43 AM
		# NISSignatureVersion             : 1.303.1684.0
		# OnAccessProtectionEnabled       : True
		# QuickScanAge                    : 2
		# QuickScanEndTime                : 13/10/2019 11:14:47 AM
		# QuickScanStartTime              : 13/10/2019 11:09:33 AM
		# RealTimeScanDirection           : 0
		# PSComputerName                  :

		$params = @{
			key = "-- some random password --";
			locale = $env:computername;		# 45 chr max
			action = "wemp-log";			# 45 chr max

			defender 					= if ( $defenderOptions.AntivirusEnabled) {'Enabled'} else {'Disabled'};
			defenderService             = if ( $defenderOptions.AMServiceEnabled) { 'Enabled' } else { 'Disabled' };
			Antispyware             	= if ( $defenderOptions.AntispywareEnabled) { 'Enabled' } else { 'Disabled' };
			OnAccessProtection          = if ( $defenderOptions.OnAccessProtectionEnabled) { 'Enabled' } else { 'Disabled' };
			RealTimeProtection          = if ( $defenderOptions.RealTimeProtectionEnabled) { 'Enabled' } else { 'Disabled' };
			executionPolicy_UserPolicy  = Get-ExecutionPolicy UserPolicy;
			executionPolicy_Process 	= Get-ExecutionPolicy Process;
			executionPolicy_CurrentUser = Get-ExecutionPolicy CurrentUser;
			executionPolicy_LocalMachine = Get-ExecutionPolicy LocalMachine;

		}

	}

}
Catch {}

$r = Invoke-WebRequest $url -Method Post -Body $params -UseBasicParsing
# dispose of r

Write-Output $r->Content;
# Write-Output $params;
