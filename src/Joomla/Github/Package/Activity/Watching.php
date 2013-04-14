<?php
/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Activity;

use Joomla\Github\Package;

/**
 * GitHub API Activity Watching Events class for the Joomla Platform.
 *
 * @documentation http://developer.github.com/v3/activity/watching/
 *
 * @package     Joomla.Platform
 * @subpackage  GitHub.Activity
 * @since       1.0
 */
class Watching extends Package
{
	/**
	 * List watchers
	 *
	 * @param   string  $owner  Repository owner.
	 * @param   string  $repo   Repository name.
	 *
	 * @since  1.0
	 *
	 * @return mixed
	 */
	public function getList($owner, $repo)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/subscribers';

		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * List repositories being watched.
	 *
	 * List repositories being watched by a user.
	 *
	 * @param   string  $user  User name.
	 *
	 * @since  1.0
	 *
	 * @return mixed
	 */
	public function getRepositories($user = '')
	{
		// Build the request path.
		$path = ($user)
			? '/users/' . $user . '/subscriptions'
			: '/user/subscriptions';

		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * Get a Repository Subscription.
	 *
	 * @param   string  $owner  Repository owner.
	 * @param   string  $repo   Repository name.
	 *
	 * @since  1.0
	 *
	 * @return mixed
	 */
	public function getSubscription($owner, $repo)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/subscription';

		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * Set a Repository Subscription.
	 *
	 * @param   string   $owner       Repository owner.
	 * @param   string   $repo        Repository name.
	 * @param   boolean  $subscribed  Determines if notifications should be received from this thread.
	 * @param   boolean  $ignored     Determines if all notifications should be blocked from this thread.
	 *
	 * @since  1.0
	 *
	 * @return object
	 */
	public function setSubscription($owner, $repo, $subscribed, $ignored)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/subscription';

		$data = array(
			'subscribed' => $subscribed,
			'ignored'    => $ignored
		);

		return $this->processResponse(
			$this->client->put($this->fetchUrl($path), json_encode($data))
		);
	}

	/**
	 * Delete a Repository Subscription.
	 *
	 * @param   string  $owner  Repository owner.
	 * @param   string  $repo   Repository name.
	 *
	 * @since  1.0
	 *
	 * @return object
	 */
	public function deleteSubscription($owner, $repo)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/subscription';

		return $this->processResponse(
			$this->client->delete($this->fetchUrl($path)),
			204
		);
	}

	/**
	 * Check if you are watching a repository (LEGACY).
	 *
	 * Requires for the user to be authenticated.
	 *
	 * @param   string  $owner  Repository owner.
	 * @param   string  $repo   Repository name.
	 *
	 * @throws \UnexpectedValueException
	 * @since  1.0
	 *
	 * @return object
	 */
	public function check($owner, $repo)
	{
		// Build the request path.
		$path = '/user/subscriptions/' . $owner . '/' . $repo;

		$response = $this->client->get($this->fetchUrl($path));

		switch ($response->code)
		{
			case '204' :
				// This repository is watched by you.
				return true;
				break;

			case '404' :
				// This repository is not watched by you.
				return false;
				break;
		}

		throw new \UnexpectedValueException('Unexpected response code: ' . $response->code);
	}

	/**
	 * Watch a repository (LEGACY).
	 *
	 * Requires for the user to be authenticated.
	 *
	 * @param   string  $owner  Repository owner.
	 * @param   string  $repo   Repository name.
	 *
	 * @since  1.0
	 *
	 * @return object
	 */
	public function watch($owner, $repo)
	{
		// Build the request path.
		$path = '/user/subscriptions/' . $owner . '/' . $repo;

		return $this->processResponse(
			$this->client->put($this->fetchUrl($path), ''),
			204
		);
	}

	/**
	 * Stop watching a repository (LEGACY).
	 *
	 * Requires for the user to be authenticated.
	 *
	 * @param   string  $owner  Repository owner.
	 * @param   string  $repo   Repository name.
	 *
	 * @since  1.0
	 *
	 * @return object
	 */
	public function unwatch($owner, $repo)
	{
		// Build the request path.
		$path = '/user/subscriptions/' . $owner . '/' . $repo;

		return $this->processResponse(
			$this->client->delete($this->fetchUrl($path)),
			204
		);
	}
}