<?php
namespace BERGWERK\BwrkSitemap\Domain\Repository;

class ViewRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function getSiteRoot()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement('SELECT * FROM pages WHERE hidden=0 AND deleted=0 AND is_siteroot=1');
        return $query->execute();
    }

    public function getAllPages()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement('SELECT * FROM pages WHERE hidden=0 AND deleted=0 AND doktype!=199 AND doktype!=254 AND nav_hide=0 AND is_siteroot=0 ORDER BY pid,sorting,uid');
        return $query->execute();
    }

    public function getAllPagesForPid($pid)
    {

    }
}