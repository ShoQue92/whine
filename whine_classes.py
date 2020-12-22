class WhineBottle:
    #Instance methods are functions you can apply on an instance of the class. Always requires the self argument (passed automaticly)
    def __init__(self, UID, name = None, main_grape = None, year = None, type = None, properties = None):
        self.UID = UID
        self.name = name
        self.main_grape = main_grape
        self.year = year
        self.type = type
        self.properties = properties
    #REPR is meant to give back a default return value when called as: repr(self), instead of object memory placeholder, give back object syntax to create it
    def __repr__(self):
        return "WhineBottle('{}', '{}', '{}')".format(self.name, self.main_grape, self.year)

    #STR is meant to give a user friendly return value when called as :str(self). Note that print(self) will first look for a __STR__ method, if not found, will return __REPR__ instead. If that is not found, will return object memory place.
    def __str__(self):
        return '{} - {} - {}'.format(self.name, self.main_grape, self.year)

    def display(self):
        return 'Fles: {} Jaar: {} '.format(self.name, self.year)

    def list_properties(self):
        for key, value in self.properties:
            return print(key, value)