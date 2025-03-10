<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'user_role',
        // 'name',
        // 'email',
        // 'password',
        // 'status',
        // 'avatar',
        'role_id',                
        'name',                      
        'email',                    
        'username',                
        'mobile',                    
        'referral_code', 
        'bio',                       
        'birthdate',               
        'gender',                    
        'location',                
        'website',                   
        'avatar',                  
        'cover',                     
        'identity_verified_at',      
        'password',                 
        'gender_id',                 
        'gender_pronoun',          
        'public_profile',           
        'paid_profile',              
        'profile_access_price',      
        'profile_access_price_6_months', 
        'profile_access_price_3_months', 
        'profile_access_price_12_months', 
        'billing_address',           
        'first_name',               
        'last_name',                
        'city',                     
        'country',                   
        'state',                    
        'postcode',                 
        'block_video_call',          
        'block_audio_call',          
        'block_message',             
        'fcm_token',                
        'remember_token',            
        'auth_provider',           
        'auth_provider_id',         
        'enable_2fa',                
        'enable_geoblocking',       
        'open_profile',              
        'enable_blur',              
        'settings',                 
        'audio_download_list',      
        'artist_verify_status',      
        'accept_term_and_policy',   
        'email_verified_at',         
        'plan_id',                   
        'purchased_plan_date',       
        'dob',                       
        'image',                     
        'status',                    
        'address',                  
        'billing_detail',           
        'country_id',                
        'state_id',                 
        'city_id',                  
        'orole',                    
        'stripe_id',              
        'stripe_status',            
        'pincode',                  
        'redirect_option',  
        'otp',      
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
