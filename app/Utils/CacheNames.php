<?php

namespace App\Utils;

class CacheNames
{
  public static function mangaMain(int $id_manga): string
  {
    return "manga-$id_manga-main";
  }

  public static function mangaLike(int $id_manga): string
  {
    return "manga-like-$id_manga";
  }

  public static function mangaChapterOrder(int $id_manga, int $chapter_order): string
  {
    return "manga-$id_manga-$chapter_order";
  }

  public static function chapterComments(int $id_chapter): string
  {
    return "chapter-$id_chapter-comments";
  }

  public static function mangasPopular(): string
  {
    return 'mangas_pop';
  }

  public static function mangasNew(int $page): string
  {
    return "mangas_new-$page";
  }

  public static function invites(int $id_invited): string
  {
    return "invites-$id_invited";
  }

  public static function scan(int $id_scan): string
  {
    return "scan-$id_scan";
  }
}
