<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\Component\Promotion\Repository\PromotionRepositoryInterface;

/**
 * @author Jan Góralski <jan.goralski@lakion.com>
 */
final class PromotionContext implements Context
{
    /**
     * @var PromotionRepositoryInterface
     */
    private $promotionRepository;

    /**
     * @param PromotionRepositoryInterface $promotionRepository
     */
    public function __construct(
        PromotionRepositoryInterface $promotionRepository
    ) {
        $this->promotionRepository = $promotionRepository;
    }

    /**
     * @Transform /^promotion "([^"]+)"$/
     * @Transform /^"([^"]+)" promotion$/
     * @Transform :promotion
     */
    public function getPromotionByName($promotionName)
    {
        $promotion = $this->promotionRepository->findOneBy(['name' => $promotionName]);
        if (null === $promotion) {
            throw new \InvalidArgumentException(
                sprintf('Promotion with name "%s" does not exist in the promotion repository.', $promotionName)
            );
        }

        return $promotion;
    }
}
