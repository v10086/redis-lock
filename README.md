📃 开源协议 Apache License Version 2.0 see http://www.apache.org/licenses/LICENSE-2.0.html
# 简介

Redis分布式锁(Distributed locks) 用Redis实现一个分布式锁管理。


版本说明
--------------------------------------------------------------------------

PHP7.0+版本 必须安装phpredis拓展

安装教程
--------------------------------------------------------------------------

composer require v10086/redis-lock:v1.0

使用示例
--------------------------------------------------------------------------


```php


        //\v10086\RedisLock::$redisHandler=\v10086\Redis::connection('default'); 设置可用的redis操作句柄
        //上锁
        $lock_key='10086';
        $lock_token=uniqid();
        $res = \v10086\RedisLock::lock($lock_key,$lock_token);
        if($res!=true){
            //锁被其它事务占用 上锁失败 返回提示
            return;
        }
        //做点其它事务处理，完成后解锁
        \v10086\RedisLock::unlock($lock_key,$lock_token);




```
