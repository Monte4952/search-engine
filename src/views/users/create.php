<?php block('content'); ?>
<div class="row">
  <div class="container">
    <?php echo sp_alert_flashes('users'); ?>
    <form method="post" action="?" class="card" data-parsley-validate>
        <?php echo $t['csrf_html']?>
      <div class="card-body form-row">
        <div class="form-group col-md-6">
          <label class="form-label" for="email"><?php echo __('E-Mail'); ?></label>
          <input type="email" name="email" id="email" value="<?php echo sp_post('email'); ?>"
          class="form-control" maxlength="200"
          data-parsley-remote="<?php echo e_attr(url_for('ajax.email_check')); ?>"
          data-parsley-remote-reverse="true"
          placeholder="<?php echo e_attr(__('tony@stark-industries.com')); ?>"
          data-parsley-remote-message="<?php echo e_attr(__('E-Mail already exists in database.')); ?>"
          required>
        </div>
        <div class="form-group col-md-6">
          <label class="form-label" for="password"><?php echo __('Password'); ?></label>
          <input type="password" name="password" id="password" class="form-control" value="<?php echo sp_post('password'); ?>"
          placeholder="<?php echo e_attr(sprintf("%d characters or more", config('internal.password_minlength'))); ?>"
          minlength="<?php echo e_attr(config('internal.password_minlength')); ?>" required>
        </div>
        <div class="form-group col-md-6">
          <label class="form-label" for="username"><?php echo __('Username'); ?> <?php echo __('(Optional)'); ?></label>
          <input
          type="text"
          name="username" id="username"
          value="<?php echo sp_post('username'); ?>"
          class="form-control"
          data-parsley-remote="<?php echo e_attr(url_for('ajax.username_check')); ?>"
          data-parsley-remote-reverse="true"
          data-parsley-remote-message="<?php echo e_attr(__('Username already exists in database.')); ?>"
          minlength="<?php echo e_attr(config('internal.username_minlength')); ?>"
          maxlength="<?php echo e_attr(config('internal.username_maxlength')); ?>"
          pattern="^[A-Za-z][A-Za-z_0-9]+$"
          placeholder="<?php echo e_attr(sprintf("A-z0-9_ only, between %d and %d characters", config('internal.username_minlength'), config('internal.username_maxlength'))); ?>"
          data-parsley-pattern-message="<?php echo e_attr(__('Please provide a valid username.')); ?>">
        </div>
        <div class="form-group col-md-6">
          <label class="form-label" for="role_id"><?php echo __('Role'); ?></label>
            <?php if (current_user_can('change_user_role')) : ?>
            <select name="role_id" class="form-control" id="role_id" required>
              <option disabled <?php echo !(int) sp_post('role_id') ? 'selected' : ''?>><?php echo __('Select user role'); ?></option>
                <?php foreach ($t['role_list'] as $_role) : ?>
                  <option value="<?php echo e_attr($_role['role_id']); ?>"
                    <?php selected($_role['role_id'], (int) sp_post('role_id')); ?>>
                    <?php echo e_attr($_role['role_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <?php else : ?>
              <input type="text" value="<?php echo __('User'); ?>" class="form-control" disabled>
            <?php endif; ?>
        </div>
        <div class="form-group col-md-6">
          <label class="form-label" for="full_name"><?php echo __('Full Name'); ?></label>
          <input type="text" name="full_name" id="full_name" value="<?php echo sp_post('full_name'); ?>"
          placeholder="<?php echo __('Tony Stark'); ?>" class="form-control"
          maxlength="200">
        </div>
        <div class="form-group col-md-6">
          <label class="form-label" for="user_ip"><?php echo __('User IP'); ?> <?php echo __('(Optional)'); ?></label>
          <input type="text" name="user_ip" id="user_ip" value="<?php echo sp_post('user_ip'); ?>"
          data-parsley-pattern-message="<?php echo e_attr(__('Please provide a valid IPv4 address')); ?>"
          placeholder="<?php echo __('127.0.0.1'); ?>" class="form-control" pattern="\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}\b">
        </div>
        <div class="form-group col-12">
          <label class="form-label" for="gender"><?php echo __('Gender'); ?></label>

          <div class="custom-controls-stacked">
            <?php foreach (sp_genders() as $_gender_id => $_gender_label) :?>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="gender" value="<?php echo e_attr($_gender_id); ?>" <?php echo (int) sp_post('gender') == $_gender_id ? 'checked' : ''; ?>>
                <span class="custom-control-label"><?php echo e($_gender_label); ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>
</div>
<div class="card-footer text-right">
        <button type="submit" class="btn btn-secondary ml-auto"><?php echo __('Create')?></button>
      </div>
    </form>
  </div>
</div>
<?php endblock(); ?>
<?php
extend(
    'admin::layouts/skeleton.php',
    [
    'title' => __('Create User'),
    'body_class' => 'users users-create',
    'page_heading' => __('Create User'),
    'page_subheading' => __('Add a new user.'),
    'page_heading_classes' => 'container'
    ]
);
