<?php

abstract class Notification
{
    protected $recipient;
    protected $sender;
    protected $unread;
    protected $type;
    protected $parameters;
    protected $referenceId;
    protected $createdAt;

    /**
     * Message generators that have to be defined in subclasses
     */
    public function messageForNotification(Notification $notification) : string;
    public function messageForNotifications(array $notifications) : string;

    /**
     * Generate message of the current notification.
     */ 
    public function message() : string
    {
        return $this->messageForNotification($this);
    }
}

namespace Notification\Comment;

class CommentLikedNotification extends \Notification
{
    /**
     * Generate a message for a single notification
     * 
     * @param Notification              $notification
     * @return string 
     */
    public function messageForNotification(Notification $notification) : string 
    {
        return $this->sender->getName() . 'has liked your comment: ' . substr($this->reference->text, 0, 10) . '...'; 
    }

    /**
     * Generate a message for a multiple notifications
     * 
     * @param array              $notifications
     * @return string 
     */
    public function messageForNotifications(array $notifications, int $realCount = 0) : string 
    {
        if ($realCount === 0) {
            $realCount = count($notifications);
        }

        // when there are two 
        if ($realCount === 2) {
            $names = $this->messageForTwoNotifications($notifications);
        }
        // less than five
        elseif ($realCount < 5) {
            $names = $this->messageForManyNotifications($notifications);
        }
        // to many
        else {
            $names = $this->messageForManyManyNotifications($notifications, $realCount);
        }

        return $names . ' liked your comment: ' . substr($this->reference->text, 0, 10) . '...'; 
    }

    /**
     * Generate a message for two notifications
     *
     *      John and Jane has liked your comment.
     * 
     * @param array              $notifications
     * @return string 
     */
    protected function messageForTwoNotifications(array $notifications) : string 
    {
        list($first, $second) = $notifications;
        return $first->getName() . ' and ' . $second->getName(); // John and Jane
    }

    /**
     * Generate a message many notifications
     *
     *      Jane, Johnny, James and Jenny has liked your comment.
     * 
     * @param array              $notifications
     * @return string 
     */
    protected function messageForManyNotifications(array $notifications) : string 
    {
        $last = array_pop($notifications);

        foreach($notifications as $notification) {
            $names .= $notification->getName() . ', ';
        }

        return substr($names, 0, -2) . ' and ' . $last->getName(); // Jane, Johnny, James and Jenny
    }

    /**
     * Generate a message for many many notifications
     *
     *      Jonny, James and 12 other have liked your comment.
     * 
     * @param array              $notifications
     * @return string 
     */
    protected function messageForManyManyNotifications(array $notifications, int $realCount) : string 
    {
        list($first, $second) = array_slice($notifications, 0, 2);

        return $first->getName() . ', ' . $second->getName() . ' and ' .  $realCount . ' others'; // Jonny, James and 12 other
    }
	
}
class NotificationManager
{
    protected $notificationAdapter;

    public function add(Notification $notification);

    public function markRead(array $notifications);

    public function get(User $user, $limit = 20, $offset = 0) : array;
}

public function add(Notification $notification)
{
    // only save the notification if no possible doublicate is found.
    if (!$this->notificationAdapter->isDoublicate($notification))
    {
        $this->notificationAdapter->add([
            'recipient_id' => $notification->recipient->getId(),
            'sender_id' => $notification->sender->getId()
            'unread' => 1,
            'type' => $notification->type,
            'parameters' => $notification->parameters,
            'reference_id' => $notification->reference->getId(),
            'created_at' => time(),
        ]);
    }
}



?>