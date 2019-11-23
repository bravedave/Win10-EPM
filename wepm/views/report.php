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
<style>
.bg-warning { background-color: #fff3cd!important; }
.bg-success { background-color: #d4edda!important; }
</style>
<h1 class="d-none d-print-block"><?= $this->title ?></h1>
<div class="table-responsive">
    <table class="table table-sm" id="<?= $tblID = strings::rand() ?>">
        <thead class="small">
            <tr>
                <td class="align-bottom text-center" line-number>#</td>
                <td class="align-bottom">updated</td>
                <td class="align-bottom text-right">elapsed</td>
                <td class="align-bottom">locale</td>
                <td class="align-bottom">winver</td>
                <td class="align-bottom text-center">defender</td>
                <td class="align-bottom text-center">Antispyware</td>
                <td class="align-bottom text-center">OnAccess<br />Protection</td>
                <td class="align-bottom text-center">RealTime<br />Protection</td>
                <td class="align-bottom text-center">Controlled<br />Folder<br />Access</td>
                <td class="align-bottom text-center">PowerShell<br />Execution<br />Policy</td>

            </tr>

        </thead>

        <tbody>
        <?php   foreach ( $this->data->dtoSet as $dto) {
            $ago = (int)( (time() - strtotime( $dto->updated)) / 60);
                ?>
            <tr
                data-id="<?= $dto->id ?>"
                <?php
                if ( $ago > 5760)
                    print 'class="bg-danger"';
                elseif ( $ago > 1440)
                    print 'class="bg-warning"';
                elseif ( $ago <= 60)
                    print 'class="bg-success"';
                ?>>

                <td class="text-center" line-number>&nbsp;&nbsp;</td>
                <td><?= strings::asLocalDate( $dto->updated, true) ?></td>
                <td class="text-right"><?php
                    if ( $ago > 1440) {
                        $minutes = $ago % 60;
                        $hours = ( ( $ago - $minutes) / 60) % 24;
                        $days = ( $ago - $minutes - ( $hours * 60)) / 1440;

                        printf( '%sd, %s:%s', $days, $hours, $minutes );
                        // printf( '%s<br />%s.%s.%s',
                        //     number_format( $ago),
                        //     $days, $hours, $minutes
                        // );

                    }
                    elseif ( $ago > 60) {
                        $minutes = $ago % 60;
                        $hours = ( $ago - $minutes) / 60;

                        printf( '%s:%s', $hours, $minutes );
                        // printf( '%s<br />%s.%s',
                        //     number_format( $ago),
                        //     $hours, $minutes
                        // );

                    }
                    else {
                        print number_format( $ago);

                    }
                        ?></td>
                <td><?= $dto->locale ?></td>
                <td><?= $dto->winver ?></td>
                <td class="text-center"><?= 'Enabled' == $dto->defender ? strings::html_tick : '<span class="text-danger">&times;</span>' ?></td>
                <td class="text-center"><?= 'Enabled' == $dto->Antispyware ? strings::html_tick : '<span class="text-danger">&times;</span>' ?></td>
                <td class="text-center"><?= 'Enabled' == $dto->OnAccessProtection ? strings::html_tick : '<span class="text-danger">&times;</span>' ?></td>
                <td class="text-center"><?= 'Enabled' == $dto->RealTimeProtection ? strings::html_tick : '<span class="text-danger">&times;</span>'  ?></td>
                <td class="text-center"><?= 'Enabled' == $dto->ControlledFolderAccess ? strings::html_tick : '<span class="text-danger">&times;</span>' ?></td>

                <?php
                $executionPolicy = json_decode( $dto->executionPolicy);
                $goodPolicy = [
                    'Undefined',
                    'Restricted',
                    'RemoteSigned',

                ];

                if (
                    in_array( $executionPolicy->UserPolicy, $goodPolicy) &&
                    in_array( $executionPolicy->Process, $goodPolicy) &&
                    in_array( $executionPolicy->CurrentUser, $goodPolicy) &&
                    in_array( $executionPolicy->LocalMachine, $goodPolicy)
                ) {
                    printf( '<td class="text-center">%s</td>', strings::html_tick);

                }
                else {
                    print '<td class="text-center text-danger">&times;</td>';

                }

                ?>


            </tr>

        <?php   }   ?>

        </tbody>

    </table>

    <p><em><small><?= date( config::$DATETIME_FORMAT) ?></small></em></p>

</div>
<script>
$(document).ready( function() {
    $('#<?= $tblID ?>').on('update-line-numbers', function( i, tr) {
        let _table = $(this);
        let lines = $('> tbody > tr', this);
        $('> thead > tr > td[line-number]', this).html( lines.length);

        lines.each( function( i, tr) {
            $('> td[line-number]', tr).html( i+1);

        });

    })
    .trigger('update-line-numbers');

    $('> tbody > tr', '#<?= $tblID ?>').each( function( i, tr) {
        let _tr = $(tr);

        _tr
        .addClass('pointer')
        .on( 'view', function( e) {
            let _me = $(this);
            let _data = _me.data();

            window.location.href = _brayworth_.url('<?= $this->route ?>/view/' + _data.id);

        })
        .on( 'delete-endpoint', function( e) {
            let _me = $(this);
            let _data = _me.data();

            _brayworth_.modal.call( $('<div title="confirm delete">are you sure ?</div>'), {
                buttons : {
                    yes : function(e) {
                        _brayworth_.post({
                            url : _brayworth_.url('<?= strings::url( $this->route ) ?>'),
                            data : {
                                action : 'delete-endpoint',
                                id : _data.id

                            },

                        }).then( function( d) {
                            _brayworth_.growl( d);
                            window.location.reload();

                        });

                        this.modal( 'close');

                    }

                }

            })

        })
        .on( 'click', function( e) {
            e.stopPropagation();e.preventDefault();

            $(this).trigger( 'view');

        })
        .on( 'contextmenu', function( e) {
            if ( e.shiftKey)
                return;

            e.stopPropagation();e.preventDefault();

            _brayworth_.hideContexts();

            let _context = _brayworth_.context();
            let _contextTarget = $(this);

            _context.append( $('<a href="#"><strong>view</strong></a>').on( 'click', function( e) {
                e.stopPropagation();e.preventDefault();

                _contextTarget.trigger( 'view');
                _context.close();


            }));

            _context.append( $('<a href="#">delete this end point</a>').on( 'click', function( e) {
                e.stopPropagation();e.preventDefault();

                _contextTarget.trigger( 'delete-endpoint');
                _context.close();


            }));

            _context.open( e);

        });;

    });

});
</script>