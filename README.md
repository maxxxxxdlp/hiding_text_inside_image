# hiding_text_inside_image
This tool lets you hide any sequence of 255 ascii symbols in a **.bmp** image
## encoding_principle
Each symbol of user's text is converted into 8 bits
Image is converted into 4d array (width, height and pixel). Each pixel of a bmp image would be an array like this: [01011010,00000010,10010101], representing red, green and blue colors in an 8 bit format
Then, last bit of each cell is overwritten with a consequetive bit from the text and image is converted back to it's original form
As a result, each of the pixels on the image can change no more than by 1/255th of a color (undetectable difference)
Resulting image may be different in size as the tool does not use any compression method for the output
## source
Source code is located in the **d3_31.php**
## try_it_online
Online version is available [here](https://mambo.in.ua/project/hiding_text/)
## contributions
Everyone is free to fix bugs, add support for other image formats and add more features
