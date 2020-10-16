class WhineBottle:
    
    #Instance methods are functions you can apply on an instance of the class. Always requires the self argument (passed automaticly)
    def __init__(self, name, grape, year):
        self.name = name
        self.grape = grape
        self.year = year

    #REPR is meant to give back a default return value when called as: repr(self), instead of object memory placeholder, give back object syntax to create it
    def __repr__(self):
        return "WhineBottle('{}', '{}', '{}')".format(self.name, self.grape, self.year)

    #STR is meant to give a user friendly return value when called as :str(self). Note that print(self) will first look for a __STR__ method, if not found, will return __REPR__ instead. If that is not found, will return object memory place.
    def __str__(self):
        return '{} - {} - {}'.format(self.name, self.grape, self.year)


class RedWhine(WhineBottle):
    def __init__(self, name, grape, year, grape_mix = None):
        super().__init__(name, grape, year)
        self.grape_mix = grape_mix
    
    def __str__(self):
        return '{} - {} - {}'.format(self.name, self.grape_mix, self.year)

class WhiteWhine(WhineBottle):
    def __init__(self, name, grape, year, dry_or_sweet, grape_mix = None):
        super().__init__(name, grape, year)
        self.dry_or_sweet = dry_or_sweet
        self.grape_mix = grape_mix

    def __str__(self):
        return '{} - {} - {}'.format(self.name, self.grape_mix, self.year)


class RoseWhine(WhineBottle):
    def __init__(self, name, grape, year, dry_or_sweet, grape_mix = None):
        super().__init__(name, grape, year)
        self.dry_or_sweet = dry_or_sweet
        self.grape_mix = grape_mix

    def __str__(self):
        return '{} - {} - {}'.format(self.name, self.grape_mix, self.year)

fles_1 = WhineBottle('generieke wijn', 'merlot', 2014)
fles_2 = RedWhine('Test rode wijn', 'Shiraz', 2015, ['Shiraz', 'Merlot'])
fles_3 = WhiteWhine('Witte wijn','Chardonnay',2016,'D',['Chardonnay', 'Sauvignon Blanc'])
fles_4 = RoseWhine('Rose wijn', 'Semillion', 2017, 'S',['Semillion','Chardonnay'])

print(fles_1)
print(fles_2)
print(fles_3)
print(fles_4)
