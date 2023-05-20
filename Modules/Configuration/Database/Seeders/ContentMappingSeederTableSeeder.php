<?php

namespace Modules\Configuration\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Configuration\Entities\ContentMapping;

class ContentMappingSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mappingData = $this->contentMappingData();
        foreach ($mappingData as $data) {
            ContentMapping::updateOrCreate(
                [
                    'code' => $data['code']
                ],
                [
                    "code" => $data['code'],
                    "error_message" => $data['error_message'],
                    "error_status" => $data['error_status'],
                    "sms" => $data['sms'],
                    "email_subject" => $data['email_subject'],
                    "email_body" => $data['email_body']
                ]
            );
        }
    }

    private function contentMappingData() {
        return [
            [
                "code" => "err_login_cred", 
                "error_message" => "Login credentials are invalid.", 
                "error_status" => 400, 
                "sms" => null, 
                "email_subject" => null, 
                "email_body" => null
            ],
            [
                "code" => "err_login_token", 
                "error_message" => "Could not create token.",
                "error_status" => 500, 
                "sms" => null, 
                "email_subject" => null, 
                "email_body" => null
            ],
        ];
    }
}
