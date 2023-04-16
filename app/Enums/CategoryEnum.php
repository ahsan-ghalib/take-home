<?php

namespace App\Enums;

use App\Traits\ArrayableEnum;

enum CategoryEnum: string
{
    use ArrayableEnum;

    case Business = 'Business';
    case Entertainment = 'Entertainment';
    case Health = 'Health';
    case Politics = 'Politics';
    case Science = 'Science';
    case Sports = 'Sports';
    case Technology = 'Technology';
    case World = 'World';
    case News = 'News';
    case Sport = 'Sport';
    case Culture = 'Culture';
    case Lifestyle = 'Lifestyle';
    case Opinion = 'Opinion';
    case Environment = 'Environment';
    case Addendum = 'Addendum';
    case An_Analysis = 'An Analysis';
    case An_Appraisal = 'An Appraisal';
    case Archives = 'Archives';
    case Article = 'Article';
    case Banner = 'Banner';
    case Biography = 'Biography';
    case Birth_Notice = 'Birth Notice';
    case Blog = 'Blog';
    case Brief = 'Brief';
    case Caption = 'Caption';
    case Chronology = 'Chronology';
    case Column = 'Column';
    case Correction = 'Correction';
    case Economic_Analysis = 'Economic Analysis';
    case Editorial = 'Editorial';
    case Editorial_Cartoon = 'Editorial Cartoon';
    case Editors_Note = 'Editors Note';
    case First_Chapter = 'First Chapter';
    case Front_Page = 'Front Page';
    case Glossary = 'Glossary';
    case Interactive_Feature = 'Interactive Feature';
    case Interactive_Graphic = 'Interactive Graphic';
    case Interview = 'Interview';
    case Letter = 'Letter';
    case List = 'List';
    case Marriage_Announcement = 'Marriage Announcement';
    case Military_Analysis = 'Military Analysis';
    case News_Analysis = 'News Analysis';
    case Newsletter = 'Newsletter';
    case Obituary = 'Obituary';
    case Obituary_OBIT = 'Obituary (Obit)';
    case Op_Ed = 'Op-Ed';
    case Paid_Death_Notice = 'Paid Death Notice';
    case Postscript = 'Postscript';
    case Premium = 'Premium';
    case Question = 'Question';
    case Quote = 'Quote';
    case Recipe = 'Recipe';
    case Review = 'Review';
    case Schedule = 'Schedule';
    case SectionFront = 'SectionFront';
    case Series = 'Series';
    case Slideshow = 'Slideshow';
    case Special_Report = 'Special Report';
    case Statistics = 'Statistics';
    case Summary = 'Summary';
    case Text = 'Text';
    case Video = 'Video';
    case Web_Log = 'Web Log';

}

