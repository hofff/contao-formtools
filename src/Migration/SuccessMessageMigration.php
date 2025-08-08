<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;
use Override;

final class SuccessMessageMigration extends AbstractMigration
{
    public function __construct(private readonly Connection $connection)
    {
    }

    #[Override]
    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->createSchemaManager();
        if (! $schemaManager->tablesExist(['tl_form'])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns('tl_form');
        $exists  = isset(
            $columns['confirmation'],
            $columns['hofff_formtools_addsuccess'],
            $columns['hofff_formtools_success'],
        );

        if (! $exists) {
            return false;
        }

        $result = $this->connection->executeQuery(
            'SELECT count(*) AS count FROM tl_form WHERE confirmation IS NULL AND hofff_formtools_addSuccess=1',
        );

        return (int) $result->fetchOne() > 0;
    }

    #[Override]
    public function run(): MigrationResult
    {
        $sql = <<<'SQL'
UPDATE tl_form 
   SET confirmation = hofff_formtools_success
 WHERE confirmation IS NULL 
   AND hofff_formtools_addSuccess=1
SQL;

        $this->connection->executeQuery($sql);

        return $this->createResult(true);
    }
}
