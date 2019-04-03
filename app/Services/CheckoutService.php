<?php
/**
 * Created by PhpStorm.
 * User: nurulratifainah
 * Date: 15/03/2019
 * Time: 10:47 PM
 */

namespace App\Services;


use App\Constants\Products;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductOffer;
use Illuminate\Support\Facades\DB;

class CheckoutService
{


    /**
     * @param int $customerID
     * @param array $orderRequests
     * @return Order|bool
     */
    public function checkout(int $customerID, array $orderRequests ){


        DB::beginTransaction();

        try{

            $price = 0;
            $orderItems = [];

            foreach ($orderRequests as $orderRequest){
                $orderItem = new OrderItem();
                $orderItem->fill($orderRequest);


                $offer = $this->getOfferByCustomer($orderItem->product_id, $customerID);
                \Log::info($offer);
                $productTotalPrice = $this->getProductPrice($orderItem, $offer);
                \Log::info($productTotalPrice);
                $orderItems[] = $orderItem;
                $price += $productTotalPrice;
            }

            $order = $this->addOrder($customerID, $price);
            $this->addOrderItem($order, $orderItems);


        }catch (\Exception $ex){
            \Log::error($ex);

            DB::rollback();
            return false;
        }

        DB::commit();


        return $order;

    }


    /**
     * @param OrderItem $orderItem
     * @param ProductOffer|null $productOffer
     * @return float|int
     */
    public function getProductPrice(OrderItem $orderItem, ProductOffer $productOffer = null){

        $unitPrice =  $orderItem->product->unit_price;
        $quantity = $orderItem->quantity;

        if($productOffer){
            switch ($productOffer->type){
                case Products::PRODUCT_OFFER_TYPE_DISCOUNTED_PRICE:
                    $unitPrice = $this->discountPrice($orderItem, $productOffer);
                    break;
                case Products::PRODUCT_OFFER_TYPE_DISCOUNTED_QUANTITY:
                    $quantity = $this->discountQuantity($orderItem->quantity, $productOffer);
                    break;
                default:
                    break;
            }
        }

        \Log::info("PId" . $orderItem->product_id);
        \Log::info("unit" . $unitPrice);
        \Log::info("quant". $quantity);
        return $this->calculatePrice($quantity, $unitPrice);
    }

    /**
     * @param $quantity
     * @param ProductOffer $productOffer
     * @return float|int
     */
    public function discountQuantity($quantity, ProductOffer $productOffer){


        if($quantity >= $productOffer->minimum_quantity) {

            $quantity = floor($quantity / $productOffer->minimum_quantity ) * $productOffer->value;

        }

        return $quantity;
    }

    /**
     * @param OrderItem $orderItem
     * @param ProductOffer $productOffer
     * @return int|mixed
     */
    public function discountPrice(OrderItem $orderItem, ProductOffer $productOffer){

        $price = $orderItem->product->unit_price;
        if($orderItem->quantity >= $productOffer->minimum_quantity) {
            $price = $productOffer->value;

        }

        return $price;
    }

    /**
     * @param int $quantity
     * @param float $price
     * @return float|int
     */
    public function calculatePrice( int $quantity, float $price){
        return $quantity * $price;
    }

    /**
     * @param $productID
     * @param int $customerID
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function getOfferByCustomer(int $productID, int $customerID){

        $offer = ProductOffer::where('customer_id', $customerID)
            ->where('product_id', $productID)
            ->where('status', Products::PRODUCT_OFFER_STATUS_ACTIVE)
            ->first();


        return $offer;

    }


    /**
     * @param int $customerID
     * @param float $price
     * @return Order
     */
    public function addOrder(int $customerID, float $price){

        $order = new Order();
        $order->customer_id = $customerID;
        $order->status = Products::PRODUCT_OFFER_STATUS_ACTIVE;
        $order->total_price = $price;

        $order->save();

        return $order;

    }

    /**
     * @param Order $order
     * @param OrderItem[] $orderItems
     * @return Order
     */
    public function addOrderItem(Order $order, $orderItems ){

        $order->orderItems()->saveMany($orderItems);


        return $order;

    }


}