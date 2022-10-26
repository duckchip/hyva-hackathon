<?php

declare(strict_types=1);

namespace Hyva\Game\Setup\Patch\Data;

use Magento\Cms\Setup\Patch\Data\CreateDefaultPages;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * This Patch adds a layout handle to the 404 page so that we can use phtml blocks on it.
 */
class AddLayoutHandleTo404Page implements DataPatchInterface
{
    public function __construct(
        private readonly ResourceConnection $resourceConnection
    ) {
    }

    public static function getDependencies(): array
    {
        return [
            CreateDefaultPages::class,
        ];
    }

    public function getAliases(): array
    {
        return [];
    }

    public function apply(): self
    {
        $sql = 'UPDATE `cms_page` set `layout_update_selected` = "Game" where `identifier` = "no-route"';
        $this->resourceConnection->getConnection()->query($sql);

        $sql = 'UPDATE `cms_page` set `content` = null';
        $this->resourceConnection->getConnection()->query($sql);

        return $this;
    }
}
