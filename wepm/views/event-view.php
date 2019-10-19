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
        <tr><td>Windows Defender</td>   <td><?= $dto->defender  ?></td>     </tr>
        <tr><td>defenderService</td>    <td><?= $dto->defenderService  ?></td>     </tr>
        <tr><td>Antispyware</td>        <td><?= $dto->Antispyware  ?></td>     </tr>
        <tr><td>OnAccessProtection</td> <td><?= $dto->OnAccessProtection  ?></td>     </tr>
        <tr><td>RealTimeProtection</td> <td><?= $dto->RealTimeProtection  ?></td>     </tr>
        <tr><td>ControlledFolderAccess</td> <td><?= $dto->ControlledFolderAccess  ?></td>     </tr>

        <tr><td colspan="2"><br />powershell execution policy</td>    </tr>
        <tr><td>UserPolicy</td>         <td><?= $executionPolicy->UserPolicy  ?></td>   </tr>
        <tr><td>Process</td>            <td><?= $executionPolicy->Process  ?></td>      </tr>
        <tr><td>CurrentUser</td>        <td><?= $executionPolicy->CurrentUser  ?></td>  </tr>
        <tr><td>LocalMachine</td>       <td><?= $executionPolicy->LocalMachine  ?></td> </tr>

    </tbody>

</table>