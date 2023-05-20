<?php

namespace Modules\Configuration\Services;

use App\Domain\GenericDomain;
use Illuminate\Support\Facades\Cache;
use Modules\Configuration\Helpers\Parser;
use Modules\Configuration\Entities\ParameterConfig;

class SecurityConfigService
{
    public static function get($code)
    {
        $config = Cache::rememberForever(GenericDomain::CACHE_TYPE['PARAMETER_CONF'], function(){
            $conf = [];
            foreach(ParameterConfig::get() as $param){
                $conf[$param['code']] = Parser::parse($param['data_type'], $param['value']);
            }
            
            return $conf;
        });

        return $config[$code];
    }
}