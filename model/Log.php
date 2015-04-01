<?php
class Log extends Illuminate\Database\Eloquent\Model {
        protected $fillable = ['type', 'content'];

        public static function record($type, $content) {
                return self::create(array(
                        'type' => $type,
                        'content' => $content,
                ));
        }

        public function scopeNewest($query) {
                return $query->orderBy('created_at', 'desc');
        }
}