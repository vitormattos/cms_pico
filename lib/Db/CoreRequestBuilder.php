<?php
/**
 * CMS Pico - Create websites using Pico CMS for Nextcloud.
 *
 * @copyright Copyright (c) 2017, Maxence Lange (<maxence@artificial-owl.com>)
 * @copyright Copyright (c) 2019, Daniel Rudolf (<picocms.org@daniel-rudolf.de>)
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace OCA\CMSPico\Db;

use Doctrine\DBAL\Query\QueryBuilder;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

class CoreRequestBuilder
{
	/** @var string */
	const TABLE_WEBSITES = 'cms_pico_websites';

	/** @var IDBConnection */
	protected $dbConnection;

	/** @var string */
	protected $defaultSelectAlias;

	/**
	 * CoreRequestBuilder constructor.
	 *
	 * @param IDBConnection $connection
	 */
	public function __construct(IDBConnection $connection) {
		$this->dbConnection = $connection;
	}

	/**
	 * Limit the request by its Id.
	 *
	 * @param IQueryBuilder $qb
	 * @param int           $id
	 */
	protected function limitToId(IQueryBuilder &$qb, $id)
	{
		$this->limitToDBField($qb, 'id', $id);
	}

	/**
	 * Limit the request to the User by its Id.
	 *
	 * @param IQueryBuilder $qb
	 * @param string        $userId
	 */
	protected function limitToUserId(IQueryBuilder &$qb, $userId)
	{
		$this->limitToDBField($qb, 'user_id', $userId);
	}

	/**
	 * Limit to the site
	 *
	 * @param IQueryBuilder $qb
	 * @param string        $userId
	 */
	protected function limitToSite(IQueryBuilder &$qb, $userId)
	{
		$this->limitToDBField($qb, 'site', $userId);
	}

	/**
	 * @param IQueryBuilder  $qb
	 * @param string         $field
	 * @param string|integer $value
	 */
	private function limitToDBField(IQueryBuilder &$qb, $field, $value)
	{
		$expr = $qb->expr();
		$pf = ($qb->getType() === QueryBuilder::SELECT) ? $this->defaultSelectAlias . '.' : '';
		$qb->andWhere($expr->eq($pf . $field, $qb->createNamedParameter($value)));
	}
}
