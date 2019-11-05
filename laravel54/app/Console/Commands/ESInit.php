<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;


class ESInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init laravel for post';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //创建template
        $Client = new Client();

        $url = config('scout.elasticsearch.hosts')[0].'/_template/tmp';
        $param = [
            'json'=>[
                'template'=>config('scout.elasticsearch.index'),
                'mapping'=>[
                    '_default_'=>[
                        'dynamic_templates'=>[
                            'strings'=>[
                                'match_mapping_type'=>'strings',
                                'mapping'=>[
                                    'type'=>'text',
                                    'analyzer'=>'ik_smart',
                                    'fields'=>[
                                        'keyword'=>[
                                            'type'=>'keyword'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $Client->put($url,$param);
        $this->info('=================创建模板成功=============');
//        创建索引
        $url = config('scout.elasticsearch.hosts')[0].'/'.config('scout.elasticsearch.index');
//        $Client ->delete($url);
        $params = [
            'json'=>[
                'setting'=>[
                    'refresh_interval'=>'5s',
                    'number_of_shards'=>1,
                    'number_of_replicas'=>0,
                ],
                'mappings'=>[
                    '_default_'=>[
                        '_all'=>[
                            'enabled'=>true,
                        ]
                    ]
                ]
            ]
        ];

        $Client->put($url,$params);

        $this->info('=================创建索引成功=============');


    }
}
