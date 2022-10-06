<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Activity
 *
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\Task|null $task
 * @method static \Database\Factories\ActivityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 */
	class Activity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Company
 *
 * @property int $id
 * @property int $owner_id
 * @property string|null $name
 * @property string|null $categorie
 * @property string|null $description
 * @property string|null $address
 * @property string|null $contact
 * @property string|null $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\customerLog[] $customerLogs
 * @property-read int|null $customer_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\User|null $users
 * @method static \Database\Factories\CompanyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string|null $address
 * @property string|null $country
 * @property string|null $contact
 * @property string|null $telephone
 * @property string|null $email
 * @property string|null $fiscal_code
 * @property int $active
 * @property int $solde
 * @property string|null $Description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\customerLog[] $customerLogs
 * @property-read int|null $customer_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Database\Factories\CustomerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFiscalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereSolde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Feedback
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $comment
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUserId($value)
 */
	class Feedback extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property int|null $order_status
 * @property string|null $order_key
 * @property string|null $ref_customer
 * @property int $montant_total
 * @property int $order_type
 * @property int $tax_1_percentage
 * @property int $tax_2_percentage
 * @property int $tax_1_amount
 * @property int $tax_2_amount
 * @property int $total_order
 * @property int $ttc_total_order
 * @property string|null $order_comment
 * @property int $remise_order
 * @property string|null $date_order
 * @property string|null $due_date_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\OrderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDateOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDueDateOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereMontantTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRefCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRemiseOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTax1Amount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTax1Percentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTax2Amount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTax2Percentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTtcTotalOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $company_id
 * @property int|null $customer_id
 * @property int|null $user_id
 * @property int|null $order_id
 * @property int $montant
 * @property string|null $method
 * @property string|null $description
 * @property string|null $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer|null $customer
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $manufacturer
 * @property string|null $description
 * @property int $is_service
 * @property string|null $refrence
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $Orders
 * @property-read int|null $orders_count
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRefrence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUserId($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Project
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property string $project_name
 * @property string|null $project_category
 * @property string|null $project_description
 * @property int|null $project_status
 * @property string|null $project_public_key
 * @property string|null $project_theme
 * @property int $project_estimated_price
 * @property string|null $project_start_date
 * @property string|null $project_end_date
 * @property int $project_template_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 * @property-read int|null $tasks_count
 * @method static \Database\Factories\ProjectFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectEstimatedPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectPublicKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUserId($value)
 */
	class Project extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Task
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $user_id
 * @property int|null $project_id
 * @property string $task_name
 * @property string|null $task_description
 * @property int $task_priority
 * @property string|null $task_theme
 * @property string $task_done
 * @property int $task_estimated_price
 * @property string|null $task_start_date
 * @property string|null $task_due_date
 * @property int|null $task_status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Project|null $project
 * @method static \Database\Factories\TaskFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTaskDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTaskDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTaskDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTaskEstimatedPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTaskName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTaskPriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTaskStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTaskStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTaskTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUserId($value)
 */
	class Task extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Task_status
 *
 * @property int $id
 * @property string $ts_name
 * @property string|null $ts_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Task_status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task_status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task_status query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task_status whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task_status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task_status whereTsDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task_status whereTsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task_status whereUpdatedAt($value)
 */
	class Task_status extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $company_id
 * @property int $customer_id
 * @property int|null $user_id
 * @property string|null $description
 * @property int $debit
 * @property int $credit
 * @property int $solde
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Customer|null $customer
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSolde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserId($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company|null $company
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\customerLog
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $customer_id
 * @property string|null $type
 * @property string|null $comment
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Customer|null $customer
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|customerLog whereUserId($value)
 */
	class customerLog extends \Eloquent {}
}

