<?php

namespace Macopedia\Community\Helper;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Pascal Jungblut <mail@pascalj.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Macopedia\Community\Domain\Model\User,
    Macopedia\Community\Domain\Model\Relation,
    Macopedia\Community\Domain\Model\AclRole;

/**
 * A Helper class for all kinds of relations.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class RelationHelper
{

    /**
     * Get the right acl rule from a relation for a certain user
     *
     * @param Relation $relation
     * @param User $user
     */
    static public function getAclRole(Relation $relation, User $user)
    {
        if ($relation->getInitiatingUser()->getUid() == $user->getUid()) {
            return $relation->getRequestedRole();
        } else {
            return $relation->getInitiatingRole();
        }
    }

    /**
     * Set the role for a relation and a user in that relation
     *
     * @param Relation $relation
     * @param User $user
     * @param AclRole $role
     */
    static public function setAclRole(
        Relation &$relation,
        User $user,
        AclRole $role
    )
    {
        if ($relation->getRequestedUser()->getUid() == $user->getUid()) {
            $relation->setRequestedRole($role);
        } else {
            $relation->setInitiatingRole($role);
        }
    }

    /**
     * Get the roles that a certain user has created
     *
     * @param User $user
     */
    static public function getRolesForUser(User $user)
    {
        $relations = RepositoryHelper::getRepository('Relation')->findRelationsForUser($user);
        foreach ($relations as $relation) {
            $roles[] = RelationHelper::getAclRole($relation, $user);
        }

        return $roles;
    }

    /**
     * get the rules for one relation
     *
     * @param Relation $relation
     * @param User $user
     */
    static public function getRulesForRelation(Relation $relation, User $user)
    {
        $role = self::getAclRole($relation, $user);
        return RepositoryHelper::getRepository('AclRule')->findByRole($role);
    }
}
