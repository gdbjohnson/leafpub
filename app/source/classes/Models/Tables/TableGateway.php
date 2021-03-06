<?php
/**
 * Leafpub: Simple, beautiful publishing. (https://leafpub.org)
 *
 * @link      https://github.com/Leafpub/leafpub
 * @copyright Copyright (c) 2017 Leafpub Team
 * @license   https://github.com/Leafpub/leafpub/blob/master/LICENSE.md (GPL License)
 */

namespace Leafpub\Models\Tables;

use Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\TableGateway\Feature;

abstract class TableGateway extends AbstractTableGateway {
    const DEFAULT_PREFIX = 'leafpub_';
    public static $prefix = '';

    public function __construct(){
        $this->table = ((empty(self::$prefix)) ? self::DEFAULT_PREFIX : self::$prefix) . $this->table;
        
        $this->featureSet = new Feature\FeatureSet();
        $this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
        //$this->featureSet->addFeature(new Feature\MetadataFeature());
        //$this->featureSet->addFeature(new Feature\RowGatewayFeature('id'));
        
        $this->initialize();
    }

    public function showSqlAndExit($select){
        var_dump(
            $this->getSql()->getSqlStringForSqlObject($select)
        );
        exit;
    }

    public function truncate(){
        return $this->getSql()->prepareStatementForSqlObject(new TruncateTable($this->getTable()))->execute();
    }
}
