@include('layouts.app')

@section('content')
<main class="flex-container">
    @include('partials.sidebar')
    <div class="features-card">
        <h1>Features</h1>
        <p>Here are some of the features that we offer:</p>
        <h2>Visitor</h2>
        <ul>
            <li>Login/ Logout</li>
            <li>Register</li>
            <li>Recover Password</li>
            <li>View the public feed</li>
            <li>View public profiles</li>
            <li>View public spaces</li>
        </ul>

        <h2>User</h2>
        <ul>
            <li>See a personalized Timeline</li>
            <li>Search users,comments, groups and spaces</li>
            <li>View Profile</li>
            <li>Edit Profile</li>
            <li>Upload a profile picture</li>
            <li>View own Notifications</li>
        </ul>


        <h2>Space</h2>
        <ul>
            <li>View Space</li>
            <li>Edit Space</li>
            <li>Delete Space</li>
            <li>Comment Space</li>
            <li>Like Space</li>
            <li>Upload Image</li>
        </ul>

        <h2>Group</h2>
        <ul>
            <li>View Group</li>
            <li>Edit Group</li>
            <li>Delete Group</li>
            <li>Create space inside Group</li>
            <li>Like Group</li>
            <li>Invite members to Group</li>
            <li>Remove members from Group</li>
        </ul>

        <h2>Message Notification</h2>
<ul>
    <li>View Message Notifications</li>
    <li>Receive Real-Time Message Notifications</li>
    <li>Mark Message Notifications as Read</li>
</ul>

        <h2>Comment</h2>
        <ul>
            <li>View Comment</li>
            <li>Edit Comment</li>
            <li>Delete Comment</li>
            <li>Like Comment</li>
            <li>Tag another user in Comment</li>
        </ul>

        <h2>Notification</h2>
        <ul>
            <li>View Notification</li>
            <li>Delete Notification</li>
            <li>Mark Notification as read</li>
            <li>Receive notifications in real-time</li>
            <li>Receive notifications when tagged in a comment</li>
            <li>Receive notifications when invited to a group</li>
            <li>Receive notifications when removed from a group</li>
            <li>Receive notifications when a user likes a comment</li>
            <li>Receive notifications when a user likes a space</li>
            <li>Receive notifications when a user adds a group to favorite</li>
        </ul>

        <h2>Admin</h2>
        <ul>
            <li>Create accounts </li>
            <li>Full Text Search </li>
            <li>Block users </li>
            <li>Unblock users </li>
            <li>delete users </li>
            <li>like spaces </li>
            <li>delete spaces </li>
            <li>edit spaces </li>
            <li>delete comment</li>
            <li>edit comment</li>
            <li>like comment</li>
            <li>delete Groups</li>
            <li>edit Groups</li>
            <li>join Groups</li>
        </ul>
    </div>
    @include('partials.sideSearchbar')
</main>
@include('partials.footer')
