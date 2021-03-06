<?php 

namespace Blog\db\Repositories;

use Blog\db\Repositories\Interfaces\UsersInterface;
use Blog\db\Repositories\Repository;

// Eloquent models
use Blog\db\Models\User;
use Blog\db\Models\Group;

// Vendor facades
use Auth;
use Spatie\Activitylog\Models\Activity;

/**
 * Class UsersRepository
 * @package Blog\db\Repositories
 */
class UsersRepository extends Repository implements UsersInterface
{
    /**
     * Group ID
     *
     * @var integer
     */
    const GROUP = 3;

    /**
     * Define model
     */
    public function __construct()
    {
        $this->model = new User;
    }

    /**
     * Find user
     * 
     * @param  integer $id
     * @return User
     */
    public function findUser($id)
    {
        return $this->model->where('id', '=', $id)->with('group')->first();
    }

    /**
     * Get user latest activities
     * 
     * @param  integer $id
     * @return Activity collection
     */
    public function getUserLatestActivities($id)
    {
        return Activity::where('user_id', '=', $id)->latest('id')->limit(5)->get();
    }

    /**
     * Get users group
     * 
     * @return Group
     */
    public function getUsersGroup()
    {
        return Group::find($this::GROUP);
    }

    /**
     * Register user
     * 
     * @param  array $data
     */
    public function registerUser($data)
    {
        $users_group = $this->getUsersGroup();

        $users_group->users()->create($data);
    }

    /**
     * Edit profile
     * 
     * @param  array    $data
     * @param  integer  $id
     */
    public function editProfile($data, $id)
    {
        $user = $this->findUser($id);

        $this->model->editProfile($data, $user);

        return $user;
    }

    /**
     * Find user articles
     * 
     * @param  integer $id
     * @return Articles collection
     */
    public function findUserArticles($id)
    {
        return $this->model->find($id)->articles()->latest('published_at')->published()->get();
    }

    /**
     * Find user comments
     * 
     * @param  integer $id
     * @return Comments collection
     */
    public function findUserComments($id)
    {
        return $this->model->find($id)->comments()->with('article')->latest('created_at')->get();
    }
}