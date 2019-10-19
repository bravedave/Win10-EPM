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
?>
<h1 class="d-none d-print-block"><?= $this->title ?></h1>
<div class="table-responsive">
    <table class="table table-sm" id="<?= $tblID = strings::rand() ?>">
        <thead>
            <tr>
                <td>created</td>
                <td>locale</td>
                <td>defender</td>

            </tr>

        </thead>

        <tbody>
        <?php   foreach ( $this->data->dtoSet as $dto) {    ?>
            <tr
                data-id="<?= $dto->id ?>">
                <td><?= strings::asLocalDate( $dto->created) ?></td>
                <td><?= $dto->locale ?></td>
                <td><?= $dto->defender ?></td>

            </tr>

        <?php   }   ?>

        </tbody>

    </table>

</div>
<script>
$(document).ready( function() {
    $('> tbody > tr', '#<?= $tblID ?>').each( function( i, tr) {
        let _tr = $(tr);

        _tr
        .addClass('pointer')
        .on( 'click', function( e) {
            let _me = $(this);
            let _data = _me.data();

            window.location.href = _brayworth_.url('<?= $this->route ?>/view/' + _data.id);

        });

    });

});
</script>