<!-- Modal -->
<div class="modal fade" id="broadcastModal" tabindex="-1" aria-labelledby="broadcastModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="broadcastModalLabel">Broadcast Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('users.broadcast') }}" method="POST">
                <div class="modal-body text-dark">
                    @csrf
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <h4>Message</h4>
                                <textarea class="form-control" name="message" id="" cols="20" rows="5" required></textarea>
                            </div>
                        </div>
                        <div class="col">
                            <h4>Template</h4>
                            <button class="btn btn-sm mb-2 btn-info form-control" type="button" onclick="setTemplate('Hi Kak <b>{name}</b>, sudah main game seru hari ini? 🎮🔥 Yuk, langsung gas! Kumpulin keseruan, tonton iklan, dan cuan mengalir tanpa ribet. Jangan sampai ketinggalan, waktunya panen cuan sekarang! 🚀💰')">Invite Users</button>
                            <button class="btn btn-sm mb-2 btn-info form-control" type="button">Announcement</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <h4>Recipients</h4>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="recipients" required
                                id="inactive0" value="0">
                            <label class="form-check-label" for="inactive0">
                                All Users
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="recipients" required
                                id="inactive1" value="1">
                            <label class="form-check-label" for="inactive1">
                                Inactive Users
                            </label>
                        </div>

                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="recipients" required
                                id="activeUsers" value="2">
                            <label class="form-check-label" for="activeUsers">
                                Active Users
                            </label>
                        </div>

                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="recipients" required
                                id="specific" value="3">
                            <label class="form-check-label" for="specific">
                                Specific Users
                            </label>
                        </div>
                        
                        <input type="text" name="specific_addresses" class="form-control" id="">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setTemplate(template) {
        $('textarea[name=message]').val(template);
    }
</script>