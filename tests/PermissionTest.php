<?php declare(strict_types=1);

namespace Tests;

use App\Models\Post;
use App\Models\User;
use App\Security\Permission;
use App\Security\Voter\AdminVoter;
use App\Security\Voter\PostVoter;
use PHPUnit\Framework\TestCase;
use Tests\Helpers\AlwaysNoVoter;
use Tests\Helpers\AlwaysYesVoter;
use Tests\Helpers\SpecificVoter;

class PermissionTest extends TestCase
{
    public function testEmptyVoters ()
    {
        $permission = new Permission();
        $user = new User('user');

        $this->assertFalse($permission->can($user, 'test'));
    }

    public function testWithTrueVoter()
    {
        $permission = new Permission();
        $user = new User('user');
        $permission->addVoter(new AlwaysYesVoter());

        $this->assertTrue($permission->can($user, 'test'));
    }

    public function testWithFalseVoter()
    {
        $permission = new Permission();
        $user = new User('user');
        $permission->addVoter(new AlwaysNoVoter());

        $this->assertFalse($permission->can($user, 'test'));
    }

    public function testWithOneVoterVoteTrue()
    {
        $permission = new Permission();
        $user = new User('user');
        $permission->addVoter(new AlwaysNoVoter());
        $permission->addVoter(new AlwaysYesVoter());

        $this->assertTrue($permission->can($user, 'test'));
    }

    public function testWithSpecificPermissionVoter()
    {
        $permission = new Permission();
        $user = new User('user');
        $permission->addVoter(new SpecificVoter());

        $this->assertFalse($permission->can($user, 'test'));
        $this->assertTrue($permission->can($user, 'specific'));
    }

    public function testPostVoter()
    {
        $user = new User('user', User::PROFIL_GUEST);
        $author = new User('author', User::PROFIL_USER);
        $admin = new User('admin', User::PROFIL_ADMIN);
        $post = new Post($author);

        $this->assertFalse(Permission::userCan($user, PostVoter::EDIT, $post));
        $this->assertTrue(Permission::userCan($author, PostVoter::EDIT, $post));
        $this->assertTrue(Permission::userCan($admin, PostVoter::EDIT, $post));

        $this->assertFalse(Permission::userCan($user, PostVoter::CREATE));
        $this->assertTrue(Permission::userCan($author, PostVoter::CREATE));
        $this->assertTrue(Permission::userCan($admin, PostVoter::CREATE));
    }

    public function testAdminVoter()
    {
        $permission = new Permission();
        $user = new User('user', User::PROFIL_ADMIN);
        $user2 = new User('user2');
        $permission->addVoter(new AdminVoter());

        $this->assertTrue($permission->can($user, AdminVoter::ADMIN));
        $this->assertFalse($permission->can($user2, AdminVoter::ADMIN));
    }
}
