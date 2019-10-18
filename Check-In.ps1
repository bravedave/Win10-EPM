#
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
###

Try
{
	$url = "http://localhost"	# development environment
	$defenderOptions = Get-MpComputerStatus;
	$active = ""

    if([string]::IsNullOrEmpty($defenderOptions)) {
		$active = "not running"

    }
    else
    {
		# AMEngineVersion                 : 1.1.16400.2
		# AMProductVersion                : 4.18.1909.6
		# AMServiceEnabled                : True
		# AMServiceVersion                : 4.18.1909.6
		# AntispywareEnabled              : True
		# AntispywareSignatureAge         : 0
		# AntispywareSignatureLastUpdated : 15/10/2019 1:28:42 AM
		# AntispywareSignatureVersion     : 1.303.1684.0
		# AntivirusEnabled                : True
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
		# RealTimeProtectionEnabled       : True
		# RealTimeScanDirection           : 0
		# PSComputerName                  :


        # Write-host "Windows Defender was found on the Server:" $env:computername -foregroundcolor "Cyan"
        # Write-host "   Is Windows Defender Enabled?" $defenderOptions.AntivirusEnabled
        # Write-host "   Is Windows Defender Service Enabled?" $defenderOptions.AMServiceEnabled
        # Write-host "   Is Windows Defender Antispyware Enabled?" $defenderOptions.AntispywareEnabled
        # Write-host "   Is Windows Defender OnAccessProtection Enabled?"$defenderOptions.OnAccessProtectionEnabled
        # Write-host "   Is Windows Defender RealTimeProtection Enabled?"$defenderOptions.RealTimeProtectionEnabled

		$active = $defenderOptions.AntivirusEnabled;

	}

}
Catch {
	$active = "not running"

}

# Make API request, selecting JSON properties from response
$params = @{
	key = "-- some random password --";
	locale = $env:computername;
	action = "wemp-log"
	event = "Windows Defender";
	active = $active;
}

$r = Invoke-WebRequest $url -Method Post -Body $params -UseBasicParsing
# dispose of r

Write-Output $r->Content
