class WhineBottle:
    #Instance methods are functions you can apply on an instance of the class. Always requires the self argument (passed automaticly)
    def __init__(self, name, main_grape, year):
        self.name = name
        self.main_grape = main_grape
        self.year = year

    #REPR is meant to give back a default return value when called as: repr(self), instead of object memory placeholder, give back object syntax to create it
    def __repr__(self):
        return "WhineBottle('{}', '{}', '{}')".format(self.name, self.main_grape, self.year)

    #STR is meant to give a user friendly return value when called as :str(self). Note that print(self) will first look for a __STR__ method, if not found, will return __REPR__ instead. If that is not found, will return object memory place.
    def __str__(self):
        return '{} - {} - {}'.format(self.name, self.main_grape, self.year)

class RedWhine(WhineBottle):
    def __init__(self, name, main_grape, year, grape_mix):
        super().__init__(name, main_grape, year)
        self.grape_mix = grape_mix
    
    def __str__(self):
        return '{} - {} - {}'.format(self.name, self.grape_mix, self.year)
    
    def print_grapes(self):
        for grape in self.grape_mix:
            print('--->', grape)

    def list_grape_mix(self):
        list = ' '.join([str(elem) for elem in self.grape_mix]) 
        return list

class WhiteWhine(WhineBottle):
    def __init__(self, name, main_grape, year, dry_or_sweet, grape_mix):
        super().__init__(name, main_grape, year)
        self.dry_or_sweet = dry_or_sweet
        self.grape_mix = grape_mix

    def __str__(self):
        return '{} - {} - {}'.format(self.name, self.grape_mix, self.year)
    
    def print_grapes(self):
        for grape in self.grape_mix:
            print('--->', grape)
    
    def list_grape_mix(self):
        list = ' '.join([str(elem) for elem in self.grape_mix]) 
        return list

class RoseWhine(WhineBottle):
    def __init__(self, name, main_grape, year, dry_or_sweet, grape_mix):
        super().__init__(name, main_grape, year)
        self.dry_or_sweet = dry_or_sweet
        self.grape_mix = grape_mix

    def __str__(self):
        return '{} - {} - {}'.format(self.name, self.grape_mix, self.year)
    
    def print_grapes(self):
        for grape in self.grape_mix:
            print('--->', grape)

    def list_grape_mix(self):
        list = ' '.join([str(elem) for elem in self.grape_mix]) 
        return list