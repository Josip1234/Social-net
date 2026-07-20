<?php

namespace Classes;

class Headings
{
    const OPEN_H1 = "<h1>";
    const OPEN_H2 = "<h2>";
    const OPEN_H3 = "<h3>";
    const OPEN_H4 = "<h4>";
    const OPEN_H5 = "<h5>";
    const OPEN_H6 = "<h6>";
    const CLOSE_H1 = "</h1>";
    const CLOSE_H2 = "</h2>";
    const CLOSE_H3 = "</h3>";
    const CLOSE_H4 = "</h4>";
    const CLOSE_H5 = "</h5>";
    const CLOSE_H6 = "</h6>";

    public function __construct(private string $headerContent)
    {
        $this->headerContent = $headerContent;
    }

    public function returnHeading(int $headerType): string
    {
        $header = "";
        switch ($headerType) {
            case '1':
                $header .= self::OPEN_H1 . $this->returnHeaderContent() . self::CLOSE_H1;
                break;
            case '2':
                $header .= self::OPEN_H2 . $this->returnHeaderContent() . self::CLOSE_H2;
                break;
            case '3':
                $header .= self::OPEN_H3 . $this->returnHeaderContent() . self::CLOSE_H3;
                break;
            case '4':
                $header .= self::OPEN_H4 . $this->returnHeaderContent() . self::CLOSE_H4;
                break;
            case '5':
                $header .= self::OPEN_H5 . $this->returnHeaderContent() . self::CLOSE_H5;
                break;
            case '6':
                $header .= self::OPEN_H6 . $this->returnHeaderContent() . self::CLOSE_H6;
                break;
            default:
                $header = "";
                break;
        }
        return $header;
    }
    public function returnHeaderContent()
    {
        return $this->headerContent;
    }
}
