# mathiasgrimm/grinza

<a href="https://travis-ci.org/mathiasgrimm/grinza"><img src="https://travis-ci.org/mathiasgrimm/grinza.svg" alt="Build Status"></a>
[![Coverage Status](https://coveralls.io/repos/github/mathiasgrimm/grinza/badge.svg)](https://coveralls.io/github/mathiasgrimm/grinza)


Experimental custom PHP Framework for studying modern object oriented concepts like S.O.L.I.D, clean code, etc



# Study Notes

## The "Router Handler" Case

The Route can either have a controller or a closure as it's handler.

Initially I wrote the Route thinking only in using a controller and therefore it had two arguments in the constructor
related to it ($controller, $controllerMethod). 
Later I decided to also support closures and then the `Open Close Principle` seemed to have being at risk.
To be continued...
