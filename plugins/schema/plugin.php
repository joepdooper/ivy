<?php

use Ivy\Setting;
use Ivy\Template;
use Spatie\SchemaOrg\Schema;

function add_schema_data(): void
{
    $schema = Schema::BlogPosting()
        ->name(Setting::getStash()['name']->value)
        ->headline(Setting::getStash()['title']->value)
        ->datePublished(Setting::getStash()['date']->value)
        ->author(Schema::Person()->name(Setting::getStash()['author']->value));
    echo $schema->toScript();
}

Template::hooks()->add_action('end_head_action', 'add_schema_data');