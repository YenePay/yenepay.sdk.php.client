<?php
class TransactionModel implements JsonSerializable {
    private $status;
    private $statusText;
    private $statusDescription;
    private $totalAmount;
    private $totalAmountETB;
    private $orderId;
    private $orderCode;
    private $paymentMethod;
    private $paymentMethodText;
    private $itemsCount;
    private $process;
    private $paymentSignature;

    public function __construct($order) {
        $this->status = $order->{'status'};
        $this->statusText = $order->{'statusText'};
        $this->statusDescription = $order->{'statusDescription'};
        $this->totalAmount = $order->{'totalAmount'};
        $this->totalAmountETB = $order->{'totalAmountETB'};
        $this->orderId = $order->{'orderId'};
        $this->orderCode = $order->{'orderCode'};
        $this->paymentMethod = $order->{'paymentMethod'};
        $this->paymentMethodText = $order->{'paymentMethodText'};
        $this->itemsCount = $order->{'itemsCount'};
        $this->process = $order->{'process'};
        $this->paymentSignature = $order->{'paymentSignature'};
    }

    public function getStatus() {
        return $this->status;
    }
    public function getStatusText() {
        return $this->statusText;
    }
    public function getStatusDescription() {
        return $this->statusDescription;
    }
    public function getTotalAmount() {
        return $this->totalAmount;
    }
    public function getTotalAmountETB() {
        return $this->totalAmountETB;
    }
    public function getOrderId() {
        return $this->orderId;
    }
    public function getOrderCode() {
        return $this->orderCode;
    }
    public function getPaymentMethod() {
        return $this->paymentMethod;
    }
    public function getPaymentMethodText() {
        return $this->paymentMethodText;
    }
    public function getItemsCount() {
        return $this->itemsCount;
    }
    public function getProcess() {
        return $this->process;
    }
    public function getPaymentSignature() {
        return $this->paymentSignature;
    }

    public function getIsPaymentCompleted() {
        return $this->status == 9? true: false;
    }

    public function jsonSerialize() {
        return [
            'status' => $this->status,
            'statusText' => $this->statusText,
            'statusDescription' => $this->statusDescription,
            'totalAmount' => $this->totalAmount,
            'totalAmountETB' => $this->totalAmountETB,
            'orderId' => $this->orderId,
            'orderCode' => $this->orderCode,
            'paymentMethod' => $this->paymentMethod,
            'paymentMethodText' => $this->paymentMethodText,
            'itemsCount' => $this->itemsCount,
            'process' => $this->process,
            'paymentSignature' => $this->paymentSignature,
            'isPaymentCompleted' => $this->getIsPaymentCompleted()
        ];
    }
}
?>