<?php

namespace Loop\MiniTracker\Api\Data;

interface TrackerInterface
{
    /**
     * String constants for property names
     */
    const SKU = "sku";
    const TRACKING_CODE = "tracking_code";
    const TRACKING_MESSAGE = "tracking_message";
    const CREATED_AT = "created_at";

    /**
     * Getter for Sku.
     *
     * @return string|null
     */
    public function getSku(): ?string;

    /**
     * Setter for Sku.
     *
     * @param string|null $sku
     *
     * @return void
     */
    public function setSku(?string $sku): void;

    /**
     * Getter for TrackingCode.
     *
     * @return string|null
     */
    public function getTrackingCode(): ?string;

    /**
     * Setter for TrackingCode.
     *
     * @param string|null $trackingCode
     *
     * @return void
     */
    public function setTrackingCode(?string $trackingCode): void;

    /**
     * Getter for TrackingMessage.
     *
     * @return string|null
     */
    public function getTrackingMessage(): ?string;

    /**
     * Setter for TrackingMessage.
     *
     * @param string|null $trackingMessage
     *
     * @return void
     */
    public function setTrackingMessage(?string $trackingMessage): void;

    /**
     * Getter for CreatedAt.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Setter for CreatedAt.
     *
     * @param string|null $createdAt
     *
     * @return void
     */
    public function setCreatedAt(?string $createdAt): void;
}
