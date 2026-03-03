<?php

namespace Database\Seeders;

use DB;
use App\Models\SMSSetting;
use Illuminate\Database\Seeder;

class SMSSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_m_s_settings')->delete();
        
        $s_m_s_settings = SMSSetting::create([

            'nexmo_key'=>'your_twilio_sid_here',
            'nexmo_secret'=>'your_twilio_sid_here',
            'nexmo_sender_name'=>'your_twilio_sid_here',
            'twilio_sid'=>'your_twilio_sid_here',
            'twilio_auth_token'=>'your_twilio_sid_here',
            'twilio_number'=>'your_twilio_sid_here',
            'status'=>'1',
            
        ]);
    }
}
