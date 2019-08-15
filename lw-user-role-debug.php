<?php
/*
Plugin Name: Debug roles
Description: Remove and register administrator roles.
Author: Florian Luce
Version: 1.0
PHP Version: 5.5+
Text Domain: debug-mu
*/

class lw_role_debug {

    /**
     * @var string
     */
    private $roleSlugName = 'debug_group';

    /**
     * @var string
     */
    private $roleName = 'Debug Group';

    /**
     * @var int
     */
    private $currentUserId;

    /**
     * lw_role_debug constructor.
     *
     * @param null $roleSlugName
     * @param null $roleName
     */
    public function __construct( $roleSlugName = null, $roleName = null )
    {
        if( $this->isRightStringValue( $roleSlugName ) ) {
            $this->roleSlugName = $roleSlugName;
        }

        if( $this->isRightStringValue( $roleName ) ) {
            $this->roleName = $roleName;
        }

//        add_action('init', $this->setCurrentUserId()); // TODO: This call method return 0 all times
//        add_action('init', array($this, 'setCurrentUserId')); // TODO: This call method not working!
    }

    /**
     * Set the current user's ID, or 0 if no user is logged in.
     *
     * @return void
     */
    private function setCurrentUserId()
    {
//        $this->currentUserId = get_current_user_id();
    }

    /**
     * Check if good value format to set.
     *
     * @param mixed $value
     * @return bool
     */
    private function isRightStringValue($value )
    {
        if( is_null( $value ) && is_string( $value ) && !empty( $value ) ) {

            return true;
        }

        return false;
    }


    /**
     * Remove an role by name.
     *
     * @param string $roleSlugName
     * @return string
     */
    public function deleteRoleByName( $roleSlugName = null )
    {
        if( false === $this->isRightStringValue( $roleSlugName ) ) {
            $roleSlugName = $this->roleSlugName;
        }

        if( !empty(get_role( $roleSlugName ) ) ) {
            remove_role( $roleSlugName );

            return "'$roleSlugName' has deleted";
        }

        return "'$roleSlugName' doesn't exist" ;
    }

    /**
     * Register 'debug_group' user role if not yet.
     * @since 0.1
     *
     * @return string
     */
    public function registerDebugRole()
    {
        if( empty( get_role( $this->roleSlugName ) ) ) {
            $result = add_role( $this->roleSlugName, __( $this->roleName ), array(
                /*/ / POSTS / /*/
                'create_posts'           => true,
                'publish_posts'          => true,
                'edit_posts'             => true,
                'edit_published_posts'   => true,
                'edit_others_posts'      => true,
                'delete_posts'           => true,
                'delete_published_posts' => true,
                'delete_others_posts'    => true,
                'read_private_posts'     => true,
                'edit_private_posts'     => true,
                'delete_private_posts'   => true,

                /*/ / POSTS OPTIONS / /*/
                'moderate_comments'      => true,
                'manage_categories'      => true,

                /*/ / PAGES / /*/
                'publish_pages'          => true,
                'edit_pages'             => true,
                'edit_published_pages'   => true,
                'edit_others_pages'      => true,
                'delete_pages'           => true,
                'delete_published_pages' => true,
                'delete_others_pages'    => true,
                'read_private_pages'     => true,
                'edit_private_pages'     => true,
                'delete_private_pages'   => true,

                /*/ / PLUGINS / /*/
                'install_plugins'        => true,
                'activate_plugins'       => true,
                'edit_plugin'            => true,
                'update_plugin'          => true,
                'delete_plugins'         => true,

                /*/ / USERS / /*/
                'create_users'           => true,
                'list_users'             => true,
                'promote_users'          => true,
                'edit_users'             => true,
                'remove_users'           => true,
                'delete_users'           => true,

                /*/ / THEMES / /*/
                'install_themes'         => true,
                'switch_themes'          => true,
                'edit_themes'            => true,
                'edit_theme_options'     => true,
                'update_theme'           => true,
                'delete_themes'          => true,

                /*/ / MEDIAS / /*/
                'edit_files'             => true,
                'upload_files'           => true,

                /*/ / OTHERS / /*/
                'read'                   => true,
                'edit_dashboard'         => true,
                'export'                 => true,
                'import'                 => true,
                'manage_links'           => true,
                'manage_options'         => true,
                'create_product'         => true,
                'update_core'            => true,
            ) );

            if( null !== $result ) {

                return "Success: '{$result->name}' user role created.";
            }
        }

        return 'Failure: user \'' . $this->roleName . '\' role already exists.';
    }


    /**
     * Set the new role for an user.
     *
     * @param int $userId
     * @param string $roleSlugName
     * @return void
     */
    public function setUserRole( $userId = null, $roleSlugName = null )
    {
        if( is_null( $userId ) || empty( $userId ) || !is_int( $userId ) ) {
//            $userId = $this->currentUserId();
            $userId = 0;
        }

        if( false === $this->isRightStringValue( $roleSlugName ) ) {
            $roleSlugName = $this->roleSlugName;
        }

        $user = new \WP_User( $userId );
        // default admin role is administrator ;)
        $user->set_role( $this->roleSlugName );
    }

    /**
     * Use and modify this function to according to your needs.
     *
     * @return mixed
     */
    public function debug_GetRolesOnThisWebsite()
    {
        global $wp_roles;
//        $all_roles = $wp_roles->roles;
//        $editable_roles = apply_filters('editable_roles', $all_roles);

        return $wp_roles;
    }
}

/**   /// HELPER ///   */
/** Is an example how to use this */

//$debug = new lw_role_debug();

//var_dump(  $debug->registerDebugRole() );
//var_dump(  $debug->deleteRoleByName() );

//$userIdToUpdate = 0;
//$debug->setUserRole( $userIdToUpdate );
