<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lakion\SyliusElasticSearchBundle\Tests\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class ProductContext implements Context
{
    /**
     * @var FixtureInterface
     */
    private $bookProductFixture;

    /**
     * @var FixtureInterface
     */
    private $mugProductFixture;

    /**
     * @var FixtureInterface
     */
    private $stickerProductFixture;

    /**
     * @param FixtureInterface $bookProductFixture
     * @param FixtureInterface $mugProductFixture
     * @param FixtureInterface $stickerProductFixture
     */
    public function __construct(
        FixtureInterface $bookProductFixture,
        FixtureInterface $mugProductFixture,
        FixtureInterface $stickerProductFixture
    ) {
        $this->bookProductFixture = $bookProductFixture;
        $this->mugProductFixture = $mugProductFixture;
        $this->stickerProductFixture = $stickerProductFixture;
    }

    /**
     * @Given the store has about :mugsNumber Mugs, :stickersNumber Stickers and :booksNumber Books
     */
    public function theStoreHasAboutMugsAndStickers($mugsNumber, $stickersNumber, $booksNumber)
    {
        $this->mugProductFixture->load(['amount' => (int) $mugsNumber]);
        $this->stickerProductFixture->load(['amount' => (int) $stickersNumber]);
        $this->bookProductFixture->load(['amount' => (int) $booksNumber]);
    }
}
