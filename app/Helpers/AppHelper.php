<?php

namespace App\Helpers;

use App\Models\Shipment;
use Illuminate\Support\Facades\Session;
use Webpatser\Uuid\Uuid;

class AppHelper
{
    public const ADMIN = [
        'id' => 1,
        'name' => 'Admin',
        'slug' => 'admin',
    ];

    public const VENDOR = [
        'id' => 2,
        'name' => 'Vendor',
        'slug' => 'vendor',
    ];

    public const USER = [
        'id' => 3,
        'name' => 'User',
        'slug' => 'user',
    ];

    public const SELL = 'sell';

    public const ADMINPERMISSIONS = [
        'dashboard_access',
    ];

    public const VENDORPERMISSIONS = [
        'dashboard_access',
    ];

    public const USERPERMISSIONS = [
        'dashboard_access',
    ];


    public static function notify($message, $type)
    {
        flasher($message, $type);
    }

    public static function getCartQty()
    {
        $data = Session::get('data') ?? [];
        if ($data) {
            return count($data);
        }
        return 0;
    }

    public static function getGrandTotal($data, $type)
    {
        if ($type == 1) {
            return array_sum(array_column($data, 'total_retail_price'));
        }
        return array_sum(array_column($data, 'total_price'));
    }

    public static function getProductTotalPrice($product, $type)
    {
        if ($type == 1) {
            return $product['total_retail_price'];
        }
        return $product['total_price'];
    }

    public static function getProductPrice($product, $type)
    {
        if ($type == 1) {
            return $product['sku_retail_price'];
        }
        return $product['sku_price'];
    }

    public static function getCompletedShipmentsCount()
    {
        return Shipment::getShipments()->where('status', 'completed')->count();
    }

    public static function getCompletedShipmentRevenue()
    {
        return Shipment::getShipments()->where('status', 'completed')->sum('total');
    }

    public static function getCompletedShipmentAveragePrice()
    {
        return Shipment::getShipments()->where('status', 'completed')->average('total');
    }

    public static function isAdmin()
    {
        return auth()->check() && auth()->user()->hasRole('admin') ? true : false;
    }

    public static function isVendor()
    {
        return auth()->check() && auth()->user()->hasRole('vendor') ? true : false;
    }

    public static function isUser()
    {
        return auth()->check() && auth()->user()->hasRole('user') ? true : false;
    }

    public static function uuid()
    {
        return Uuid::generate()->string;
    }
}
