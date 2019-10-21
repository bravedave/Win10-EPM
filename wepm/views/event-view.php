<?php
/*
 * David Bray
 * BrayWorth Pty Ltd
 * e. david@brayworth.com.au
 *
 * This work is licensed under a Creative Commons Attribution 4.0 International Public License.
 *      http://creativecommons.org/licenses/by/4.0/
 *
*/

// sys::dump( $this->data);
$dto = $this->data->dto;
$executionPolicy = json_decode( $dto->executionPolicy);

?>

<table class="table table-sm">
    <tbody>
        <tr><td>id</td>                 <td><?= $dto->id  ?></td>           </tr>
        <tr><td>created</td>            <td><?= strings::asLocalDate( $dto->created, $time = true)  ?></td>  </tr>
        <tr><td>locale</td>             <td><?= $dto->locale  ?></td>       </tr>
        <tr>
            <td colspan="2" class="p-0">
                <table class="table table-sm m-0">
                    <thead>
                        <tr><td colspan="6">Windows Defender</td></tr>
                        <tr class="small">
                            <td class="text-center align-bottom">Status</td>
                            <td class="text-center align-bottom">Service</td>
                            <td class="text-center align-bottom">Antispyware</td>
                            <td class="text-center align-bottom">OnAccess<br />Protection</td>
                            <td class="text-center align-bottom">RealTime<br />Protection</td>
                            <td class="text-center align-bottom">Controlled<br />Folder Access</td>

                        </tr>

                    </thead>

                    <tbody>
                        <tr>
                            <td class="text-center"><?= 'Enabled' == $dto->defender ? sprintf( '<span class="text-success">%s</span>', strings::html_tick) : '<span class="text-danger">&times;</span>' ?></td>
                            <td class="text-center"><?= 'Enabled' == $dto->defenderService ? sprintf( '<span class="text-success">%s</span>', strings::html_tick) : '<span class="text-danger">&times;</span>' ?></td>
                            <td class="text-center"><?= 'Enabled' == $dto->Antispyware ? sprintf( '<span class="text-success">%s</span>', strings::html_tick) : '<span class="text-danger">&times;</span>' ?></td>
                            <td class="text-center"><?= 'Enabled' == $dto->OnAccessProtection ? sprintf( '<span class="text-success">%s</span>', strings::html_tick) : '<span class="text-danger">&times;</span>' ?></td>
                            <td class="text-center"><?= 'Enabled' == $dto->RealTimeProtection ? sprintf( '<span class="text-success">%s</span>', strings::html_tick) : '<span class="text-danger">&times;</span>' ?></td>
                            <td class="text-center"><?= 'Enabled' == $dto->ControlledFolderAccess ? sprintf( '<span class="text-success">%s</span>', strings::html_tick) : '<span class="text-danger">&times;</span>' ?></td>

                        </tr>

                    </tbody>

                </table>

            </td>

        </tr>

        <tr><td colspan="2"><br />powershell execution policy</td>    </tr>
        <tr><td>UserPolicy</td>         <td><?= $executionPolicy->UserPolicy  ?></td>   </tr>
        <tr><td>Process</td>            <td><?= $executionPolicy->Process  ?></td>      </tr>
        <tr><td>CurrentUser</td>        <td><?= $executionPolicy->CurrentUser  ?></td>  </tr>
        <tr><td>LocalMachine</td>       <td><?= $executionPolicy->LocalMachine  ?></td> </tr>

    </tbody>

</table>

<h6>PowerShell Execution Policy</h6>

<p>to change the execution policy to Undefined (Strict) (recommended)</p>
<ol>
    <li>start <strong>PowerShell</strong> with <strong>Run as Administrator</strong></li>
    <li>view the policies with <strong>Get-ExecutionPolicy -List</strong></li>
    <li>set the policies with (noting that process is the currently executing process):
        <ul class="font-weight-bold">
            <li>Set-ExecutionPolicy -ExecutionPolicy Undefined -Scope UserPolicy</li>
            <li>Set-ExecutionPolicy -ExecutionPolicy Undefined -Scope CurrentUser</li>
            <li>Set-ExecutionPolicy -ExecutionPolicy Undefined -Scope MachinePolicy</li>
            <li>Set-ExecutionPolicy -ExecutionPolicy Undefined -Scope LocalMachine</li>

        </ul>

    </li>

</ol>

<ul>
    <li><a href="https://docs.microsoft.com/en-us/powershell/module/microsoft.powershell.security/set-executionpolicy?view=powershell-6">See Windows Documents</a></li>

</ul>

