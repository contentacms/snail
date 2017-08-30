# snail

Snail module prevents Drupal's router from looking at path aliases for nodes when making routing decisions.

In decoupled applications you don't want all routes in Drupal to be valid routes in your front-end application, and sometimes you might even want to create a piece of content which has the same URL as an existing Drupal route (e.g. "/admin").

This module will allow you to continue using an entity's path field, which gives you collison detection, token integration, and redirect support, but without causing any routing side-effects in your Drupal site. So instead of this:

![Shows a node that has had it's path set to "/admin"](https://pbs.twimg.com/media/DDE5n7kWsAA0ASO.jpg:large)

You will continue to get your usual admin page.

Based upon an idea from [@justafish](http://github.com/justafish).

## ¡Don't install this module on sites with Drupal as a frontend. It will break path aliases!

## Name of the module

In the context of decoupled architecture and routing people talk about the concept of slugs. In Drupal these things are mostly
call path aliases. This module protects the path aliase system aka. slugs, much like a snail is a protected slug.
