<li class="notifications {{ $notification->unread() ? 'unread' : ''}}">
    <a href="{{ $notification->unread() ? '/notification/'. $notification->id .' ?redirect_url=/inbox/'. $notification->data['dialog'] : '/inbox/'. $notification->data['dialog']}}">{{ $notification->data['name'] }}</a>给你发了信息
</li>