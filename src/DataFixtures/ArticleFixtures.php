<?php
/**
 * Created by PhpStorm.
 * User: worti
 * Date: 26/11/18
 * Time: 09:55
 */

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 50; $i++)
        {
            $faker = Faker\Factory::create('fr_FR');
            $article = new Article();
            $article->setTitle(mb_strtolower($faker->sentence($nbWords = 6, $variableNbWords = true)));
            $article->setContent(mb_strtolower($faker->text($maxNbChars = 200)));
            $manager->persist($article);
            $article->setCategory($this->getReference('categorie_' . rand(0, 4)));
            // categorie_0 fait reference à la premiere categorie générée.
        }
        $manager->flush();
    }
}