<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'referer_id',
        'credit_points',
        'referral_count',
    ];

    public static function createReward(int $refId)
    {
        $refDetail = Reward::getRewardByReferrer($refId);;
        /*echo $refId;
        echo $refDetail;
        exit();*/
        if ($refDetail == null) {
            Reward::create([
                'referer_id' => $refId,
                'credit_points' => 2,
                'referral_count' => 1
            ]);
        } else {
            if ($refDetail['referral_count'] <= 3) {
                Reward::updateReward($refDetail, $refDetail['referral_count'] + 1, $refDetail['credit_points'] + 2);
            }
            if ($refDetail['referral_count'] >= 3 && $refDetail['referral_count'] <= 9) {
                Reward::updateReward($refDetail, $refDetail['referral_count'] + 1, $refDetail['credit_points'] + 1);
            }
            if ($refDetail['referral_count'] == 9) {
                Reward::updateReward($refDetail, 1, $refDetail['credit_points'] + 2);
            }
        }
    }

    public static function updateReward(Reward $refDetai, int $refCount, int $creditPoint)
    {
        Reward::whereId($refDetai['id'])->update(['referral_count' => $refCount, 'credit_points' => $creditPoint]);
    }

    public static function getCreditpoints(int $referer_id)
    {
        $checkReward = Reward::select("credit_points")->where('referer_id', '=', $referer_id)->first();
        if($checkReward == null){
            return 0;
        }else{
            return $checkReward['credit_points'];
        }
    }

    public static function getRewardByReferrer(int $referer_id){
        return Reward::where('referer_id', '=', $referer_id)->first();
    }


}
