api = 2
core = 7.x

; Include the definition for how to build Drupal core directly:
includes[] = drupal-org-core.make

; Dosomething Profile
projects[dosomething][type] = profile
projects[dosomething][download][type] = file
projects[dosomething][download][url] = "drupal-org.make"
