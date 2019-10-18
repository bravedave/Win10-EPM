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

namespace dvc\wepm\dao;
use dao\_dao;

class wepm_event extends _dao {
    protected $_db_name = 'wepm_event';

    function getUniqueSince( string $date) : array {
        $sql = sprintf('SELECT
                we1.*
            FROM
                wepm_event we1
                JOIN (SELECT
                            locale, MAX(created) created
                        FROM
                            wepm_event
                        WHERE
                            created >= "%s"
                        GROUP BY
                            locale) we2
                        ON we1.locale = we2.locale
                        AND we1.created = we2.created', date('Y-m-d', strtotime( $date)));

        if ( $res = $this->Result($sql)) {
            return $res->dtoSet();

        }

        return [];

    }

}
