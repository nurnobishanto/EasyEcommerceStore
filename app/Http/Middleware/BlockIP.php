<?php

namespace App\Http\Middleware;

use App\Models\IpBlock;
use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BlockIP
{

    public function handle(Request $request, Closure $next)
    {
        $userIp = $request->ip();
        $key = 'order_limit_' . $userIp;
        $blockIp = IpBlock::where('ip_address',$userIp)->where('status','active')->first();
        if ($blockIp){
            toastr()->error('আপনাকে ব্লক করা হয়েছে এবং এই সাইটে আর অর্ডার দিতে পারবেন না।');
            return redirect()->route('home');
        }

//        if ($request->session()->has($key)) {
//            // Check if the last order was placed today.
//            $lastOrderTimestamp = $request->session()->get($key);
//            $todayTimestamp = Carbon::now()->startOfDay()->timestamp;
//            $hoursAgoTimestamp = Carbon::now()->subHours(12)->timestamp;
//            if ($lastOrderTimestamp >= $hoursAgoTimestamp) {
//                // You can block the IP by storing a flag in the session or another method.
//                toastr()->error('আপনি এই মুহূর্তে অর্ডার করতে পারবেন না');
//                return redirect()->route('home');
//            }
//        }
        return $next($request);
    }
}
